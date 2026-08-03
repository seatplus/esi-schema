#!/usr/bin/env php
<?php

/**
 * Classify the difference between two .esi/surface.json manifests as
 * major | minor | patch | none, or undecidable.
 *
 * Usage:
 *   php bin/api-diff.php --old=<path> --new=<path> [--format=json|markdown|bump]
 *
 * Exit codes:
 *   0  a verdict was reached (read it from stdout)
 *   2  undecidable — a human must look
 *   1  usage error
 *
 * Design notes
 * ------------
 * Every symbol in a manifest embeds its own type, so this script never has to
 * understand PHP. It splits each symbol into an *identity* (what the thing is) and
 * a *detail* (its current shape), then reasons over three sets: identities that
 * disappeared, identities that appeared, and identities whose detail changed.
 *
 * The bias is deliberate and asymmetric: anything this script cannot categorise
 * escalates to `undecidable`, never down to `minor`. A needless major costs one
 * version number that no consumer is forced to take; a break shipped as a minor
 * reaches every `^N.0` consumer on their next `composer update`, and a published
 * Packagist tag cannot be withdrawn.
 *
 * Do not edit manually in ways that change a verdict without adding a fixture to
 * tests/Unit/ApiDiffTest.php first. This script decides what gets published.
 */

declare(strict_types=1);

const BUMP_NONE  = 'none';
const BUMP_PATCH = 'patch';
const BUMP_MINOR = 'minor';
const BUMP_MAJOR = 'major';

const RANK = [
    BUMP_NONE  => 0,
    BUMP_PATCH => 1,
    BUMP_MINOR => 2,
    BUMP_MAJOR => 3,
];

/**
 * Constants whose *value* is CCP-side data rather than a compile-time contract.
 * A change here recompiles fine everywhere, so it is a patch — the same category
 * as a docblock edit. REQUIRED_SCOPE is deliberately NOT in this list; it gets its
 * own rule below.
 */
const METADATA_CONSTS = [
    'CACHE_AGE',
    'RATE_LIMIT_GROUP',
    'RATE_LIMIT_MAX_TOKENS',
    'RATE_LIMIT_WINDOW',
    'USES_CURSOR',
];

const SUPPORTED_SCHEMA_VERSION = 1;

// ---------------------------------------------------------------------------
// Arguments
// ---------------------------------------------------------------------------

$args = [];
foreach (array_slice($_SERVER['argv'] ?? [], 1) as $arg) {
    if (str_starts_with($arg, '--')) {
        [$k, $v] = explode('=', ltrim($arg, '-'), 2) + [1 => 'true'];
        $args[$k] = $v;
    }
}

$oldPath = $args['old'] ?? null;
$newPath = $args['new'] ?? null;
$format  = $args['format'] ?? 'json';

if ($oldPath === null || $newPath === null) {
    fwrite(STDERR, "usage: php bin/api-diff.php --old=<surface.json> --new=<surface.json> [--format=json|markdown|bump]\n");
    exit(1);
}

if (! in_array($format, ['json', 'markdown', 'bump'], true)) {
    fwrite(STDERR, "unknown --format '{$format}'; expected json, markdown or bump\n");
    exit(1);
}

// ---------------------------------------------------------------------------
// Load
// ---------------------------------------------------------------------------

/**
 * @return array{symbols: list<string>}|null
 */
function loadManifest(string $path): ?array
{
    if (! is_file($path)) {
        return null;
    }

    $raw = file_get_contents($path);
    if ($raw === false) {
        return null;
    }

    try {
        /** @var mixed $decoded */
        $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        return null;
    }

    if (! is_array($decoded) || ! isset($decoded['symbols']) || ! is_array($decoded['symbols'])) {
        return null;
    }

    if (($decoded['schemaVersion'] ?? null) !== SUPPORTED_SCHEMA_VERSION) {
        return null;
    }

    /** @var list<string> $symbols */
    $symbols = array_values(array_filter($decoded['symbols'], 'is_string'));

    return ['symbols' => $symbols];
}

/**
 * @param list<string> $reasons
 */
function emitUndecidable(array $reasons, string $format): never
{
    $payload = [
        'bump'        => null,
        'undecidable' => true,
        'reasons'     => $reasons,
        'breaking'    => [],
        'additions'   => [],
        'notes'       => [],
    ];

    if ($format === 'bump') {
        echo "undecidable\n";
    } elseif ($format === 'markdown') {
        echo "## Cannot classify this change\n\n";
        foreach ($reasons as $reason) {
            echo "- {$reason}\n";
        }
        echo "\nA human needs to look at this. No release will be cut.\n";
    } else {
        echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n";
    }

    exit(2);
}

$old = loadManifest($oldPath);
$new = loadManifest($newPath);

$loadProblems = [];
if ($old === null) {
    $loadProblems[] = "could not read a schemaVersion " . SUPPORTED_SCHEMA_VERSION . " manifest at {$oldPath}";
}
if ($new === null) {
    $loadProblems[] = "could not read a schemaVersion " . SUPPORTED_SCHEMA_VERSION . " manifest at {$newPath}";
}
if ($loadProblems !== []) {
    emitUndecidable($loadProblems, $format);
}

// ---------------------------------------------------------------------------
// Split symbols into identity => detail
// ---------------------------------------------------------------------------

/**
 * @param list<string> $symbols
 *
 * @return array{entries: array<string, array{kind: string, detail: string, symbol: string}>, unknown: list<string>}
 */
function indexSymbols(array $symbols): array
{
    $entries = [];
    $unknown = [];

    foreach ($symbols as $symbol) {
        // class <FQCN>
        if (preg_match('/^class (\S+)$/', $symbol, $m) === 1) {
            $entries["class {$m[1]}"] = ['kind' => 'class', 'detail' => '', 'symbol' => $symbol];

            continue;
        }

        // const <FQCN>::<NAME> <type> = <value>
        if (preg_match('/^const (\S+::\w+) (.+)$/', $symbol, $m) === 1) {
            $entries["const {$m[1]}"] = ['kind' => 'const', 'detail' => $m[2], 'symbol' => $symbol];

            continue;
        }

        // prop <FQCN>::$<name> <type> required|optional
        if (preg_match('/^prop (\S+::\$\w+) (.+)$/', $symbol, $m) === 1) {
            $entries["prop {$m[1]}"] = ['kind' => 'prop', 'detail' => $m[2], 'symbol' => $symbol];

            continue;
        }

        // method <FQCN>::<name>(<params>): <return> [@return <generic>]
        if (preg_match('/^method (\S+?::\w+)\((.*)$/', $symbol, $m) === 1) {
            $entries["method {$m[1]}"] = ['kind' => 'method', 'detail' => '(' . $m[2], 'symbol' => $symbol];

            continue;
        }

        $unknown[] = $symbol;
    }

    return ['entries' => $entries, 'unknown' => $unknown];
}

$oldIndex = indexSymbols($old['symbols']);
$newIndex = indexSymbols($new['symbols']);

$unknown = array_merge($oldIndex['unknown'], $newIndex['unknown']);
if ($unknown !== []) {
    emitUndecidable(
        array_map(static fn (string $s): string => "unrecognised symbol form: {$s}", array_slice($unknown, 0, 10)),
        $format,
    );
}

$oldEntries = $oldIndex['entries'];
$newEntries = $newIndex['entries'];

// ---------------------------------------------------------------------------
// Classify
// ---------------------------------------------------------------------------

/** @var list<array{rule: string, subject: string, detail: string}> $breaking */
$breaking = [];
/** @var list<array{rule: string, subject: string, detail: string}> $additions */
$additions = [];
/** @var list<array{rule: string, subject: string, detail: string}> $notes */
$notes = [];

/**
 * Monotonic verdict accumulator: the overall bump is the highest level any rule
 * reached, and it can only ever ratchet upward.
 */
final class Verdict
{
    private string $level = BUMP_NONE;

    public function raise(string $level): void
    {
        if (RANK[$level] > RANK[$this->level]) {
            $this->level = $level;
        }
    }

    public function level(): string
    {
        return $this->level;
    }
}

$verdict = new Verdict();

/** Is this PHP type string nullable? */
function isNullable(string $type): bool
{
    return str_starts_with($type, '?') || $type === 'mixed' || str_contains($type, 'null');
}

function baseType(string $type): string
{
    return ltrim($type, '?');
}

/**
 * Split a rendered parameter list into individual parameters.
 *
 * @return list<string>
 */
function splitParams(string $paramList): array
{
    $paramList = trim($paramList);
    if ($paramList === '') {
        return [];
    }

    $params = [];
    $depth  = 0;
    $buffer = '';

    foreach (str_split($paramList) as $char) {
        if ($char === '<' || $char === '(' || $char === '[') {
            $depth++;
        }
        if ($char === '>' || $char === ')' || $char === ']') {
            $depth--;
        }
        if ($char === ',' && $depth === 0) {
            $params[] = trim($buffer);
            $buffer   = '';

            continue;
        }
        $buffer .= $char;
    }

    if (trim($buffer) !== '') {
        $params[] = trim($buffer);
    }

    return $params;
}

// --- identities that disappeared -------------------------------------------
// A removal is a break for every kind of symbol. The one exception handled
// below is a const whose identity survives but whose value moved.

foreach ($oldEntries as $identity => $entry) {
    if (isset($newEntries[$identity])) {
        continue;
    }

    $breaking[] = [
        'rule'    => "{$entry['kind']}.removed",
        'subject' => $identity,
        'detail'  => $entry['detail'],
    ];
    $verdict->raise(BUMP_MAJOR);
}

// --- identities that appeared ----------------------------------------------

foreach ($newEntries as $identity => $entry) {
    if (isset($oldEntries[$identity])) {
        continue;
    }

    $additions[] = [
        'rule'    => "{$entry['kind']}.added",
        'subject' => $identity,
        'detail'  => $entry['detail'],
    ];
    $verdict->raise(BUMP_MINOR);
}

// --- identities whose shape changed ----------------------------------------

foreach ($newEntries as $identity => $newEntry) {
    $oldEntry = $oldEntries[$identity] ?? null;
    if ($oldEntry === null || $oldEntry['detail'] === $newEntry['detail']) {
        continue;
    }

    $change = ['subject' => $identity, 'detail' => "{$oldEntry['detail']} -> {$newEntry['detail']}"];

    switch ($newEntry['kind']) {
        case 'const':
            $constName = substr($identity, (int) strrpos($identity, ':') + 1);

            // Declared type moved (?int -> ?string): a compile-time contract broke.
            $oldType = explode(' ', $oldEntry['detail'])[0];
            $newType = explode(' ', $newEntry['detail'])[0];
            if ($oldType !== $newType) {
                $breaking[] = ['rule' => 'const.retyped'] + $change;
                $verdict->raise(BUMP_MAJOR);

                break;
            }

            if (in_array($constName, METADATA_CONSTS, true)) {
                // CCP-side data. Recompiles everywhere; behaviour note only.
                $notes[] = ['rule' => 'const.metadataValueChanged'] + $change;
                $verdict->raise(BUMP_PATCH);

                break;
            }

            if ($constName === 'REQUIRED_SCOPE') {
                // Also CCP-side data, and already signalled by the compatibility
                // date. A caller's OAuth grant may need revisiting, so it must
                // appear in the release notes — but it is not a source break.
                $notes[] = ['rule' => 'const.requiredScopeChanged'] + $change;
                $verdict->raise(BUMP_MINOR);

                break;
            }

            if ($constName === 'REQUIRED_ROLES') {
                $oldRoles = substr_count($oldEntry['detail'], "'");
                $newRoles = substr_count($newEntry['detail'], "'");
                if ($newRoles > $oldRoles) {
                    // A new in-game role is now required: calls that worked stop working.
                    $breaking[] = ['rule' => 'const.requiredRolesGained'] + $change;
                    $verdict->raise(BUMP_MAJOR);
                } else {
                    $notes[] = ['rule' => 'const.requiredRolesLost'] + $change;
                    $verdict->raise(BUMP_MINOR);
                }

                break;
            }

            // Any other constant is treated as a contract, not as data.
            $breaking[] = ['rule' => 'const.valueChanged'] + $change;
            $verdict->raise(BUMP_MAJOR);

            break;

        case 'prop':
            [$oldType, $oldPresence] = array_pad(explode(' ', $oldEntry['detail']), 2, '');
            [$newType, $newPresence] = array_pad(explode(' ', $newEntry['detail']), 2, '');

            if (baseType($oldType) !== baseType($newType)) {
                $breaking[] = ['rule' => 'prop.retyped'] + $change;
                $verdict->raise(BUMP_MAJOR);

                break;
            }

            if (! isNullable($oldType) && isNullable($newType)) {
                // These DTOs are outputs: every reader of $dto->x can now get null.
                $breaking[] = ['rule' => 'prop.gainedNullability'] + $change;
                $verdict->raise(BUMP_MAJOR);

                break;
            }

            if (isNullable($oldType) && ! isNullable($newType)) {
                $notes[] = ['rule' => 'prop.lostNullability'] + $change;
                $verdict->raise(BUMP_MINOR);

                break;
            }

            // Same type, presence flipped. Constructor argument order is not part
            // of this package's contract (DTOs are built by ::from() or with named
            // arguments only — see ARCHITECTURE), so this is reader-safe.
            $notes[] = ['rule' => 'prop.presenceChanged'] + $change;
            $verdict->raise(BUMP_MINOR);

            break;

        case 'method':
            $oldSignature = $oldEntry['detail'];
            $newSignature = $newEntry['detail'];

            $oldReturn = substr($oldSignature, (int) strrpos($oldSignature, ')') + 1);
            $newReturn = substr($newSignature, (int) strrpos($newSignature, ')') + 1);

            if ($oldReturn !== $newReturn) {
                $breaking[] = ['rule' => 'method.returnChanged'] + $change;
                $verdict->raise(BUMP_MAJOR);

                break;
            }

            $oldParams = splitParams((string) substr($oldSignature, 1, (int) strrpos($oldSignature, ')') - 1));
            $newParams = splitParams((string) substr($newSignature, 1, (int) strrpos($newSignature, ')') - 1));

            // Every pre-existing parameter must survive unchanged and in place,
            // or existing call sites break.
            $prefixIntact = count($newParams) >= count($oldParams);
            if ($prefixIntact) {
                foreach ($oldParams as $i => $oldParam) {
                    if (($newParams[$i] ?? null) !== $oldParam) {
                        $prefixIntact = false;

                        break;
                    }
                }
            }

            if (! $prefixIntact) {
                $breaking[] = ['rule' => 'method.signatureChanged'] + $change;
                $verdict->raise(BUMP_MAJOR);

                break;
            }

            // Purely appended parameters. Safe only if every one has a default.
            $appended    = array_slice($newParams, count($oldParams));
            $allOptional = $appended !== [];
            foreach ($appended as $param) {
                if (! str_contains($param, '=')) {
                    $allOptional = false;

                    break;
                }
            }

            if ($allOptional) {
                $additions[] = ['rule' => 'method.optionalParamAdded'] + $change;
                $verdict->raise(BUMP_MINOR);

                break;
            }

            $breaking[] = ['rule' => 'method.requiredParamAdded'] + $change;
            $verdict->raise(BUMP_MAJOR);

            break;

        default:
            emitUndecidable(["cannot compare a '{$newEntry['kind']}' symbol: {$identity}"], $format);
    }
}

// ---------------------------------------------------------------------------
// Output
// ---------------------------------------------------------------------------

usort($breaking, static fn (array $a, array $b): int => [$a['rule'], $a['subject']] <=> [$b['rule'], $b['subject']]);
usort($additions, static fn (array $a, array $b): int => [$a['rule'], $a['subject']] <=> [$b['rule'], $b['subject']]);
usort($notes, static fn (array $a, array $b): int => [$a['rule'], $a['subject']] <=> [$b['rule'], $b['subject']]);

if ($format === 'bump') {
    echo $verdict->level(), "\n";
    exit(0);
}

if ($format === 'json') {
    echo json_encode([
        'bump'        => $verdict->level(),
        'undecidable' => false,
        'breaking'    => $breaking,
        'additions'   => $additions,
        'notes'       => $notes,
        'counts'      => [
            'breaking'  => count($breaking),
            'additions' => count($additions),
            'notes'     => count($notes),
        ],
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n";
    exit(0);
}

// markdown
$headline = match ($verdict->level()) {
    BUMP_MAJOR => 'MAJOR — the public API broke',
    BUMP_MINOR => 'MINOR — the public API grew',
    BUMP_PATCH => 'PATCH — metadata only',
    default     => 'No API change',
};

echo "## API diff verdict: {$headline}\n\n";

if ($breaking !== []) {
    echo '### Breaking (' . count($breaking) . ")\n\n";
    foreach ($breaking as $item) {
        echo "- `{$item['subject']}` — {$item['rule']}";
        echo $item['detail'] !== '' ? ": {$item['detail']}\n" : "\n";
    }
    echo "\n";
}

if ($notes !== []) {
    echo '### Behaviour notes (' . count($notes) . ")\n\n";
    foreach ($notes as $item) {
        echo "- `{$item['subject']}` — {$item['rule']}: {$item['detail']}\n";
    }
    echo "\n";
}

if ($additions !== []) {
    echo '### Additions (' . count($additions) . ")\n\n";
    $shown = array_slice($additions, 0, 40);
    foreach ($shown as $item) {
        echo "- `{$item['subject']}` — {$item['rule']}\n";
    }
    if (count($additions) > count($shown)) {
        echo '- …and ' . (count($additions) - count($shown)) . " more\n";
    }
    echo "\n";
}

if ($breaking === [] && $additions === [] && $notes === []) {
    echo "The public API surface is unchanged.\n";
}

exit(0);
