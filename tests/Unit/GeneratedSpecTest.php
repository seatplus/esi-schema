<?php

declare(strict_types=1);

use Seatplus\EsiSchema\GeneratedSpec;

/**
 * These tests are the reason GeneratedSpec exists.
 *
 * Before it, the compatibility date lived only in prose and in ~525 generated
 * docblocks, so no invariant about it could be asserted at all — which is how
 * main came to sit three compatibility dates behind its own README.
 */
function repoRoot(): string
{
    return dirname(__DIR__, 2);
}

/** @return array<string, mixed> */
function esiState(): array
{
    $json = file_get_contents(repoRoot() . '/.esi/state.json');
    expect($json)->not->toBeFalse();

    /** @var array<string, mixed> $decoded */
    $decoded = json_decode((string) $json, true, 512, JSON_THROW_ON_ERROR);

    return $decoded;
}

it('agrees with .esi/state.json', function (): void {
    $state = esiState();

    expect(GeneratedSpec::COMPATIBILITY_DATE)->toBe($state['compatibility_date'])
        ->and(GeneratedSpec::SPEC_SHA256)->toBe($state['spec_sha256']);
});

it('carries a real ISO-8601 compatibility date', function (): void {
    expect(GeneratedSpec::COMPATIBILITY_DATE)->toMatch('/^\d{4}-\d{2}-\d{2}$/');

    [$year, $month, $day] = array_map(intval(...), explode('-', GeneratedSpec::COMPATIBILITY_DATE));

    expect(checkdate($month, $day, $year))->toBeTrue();
});

it('carries a sha256 of the vendored spec', function (): void {
    expect(GeneratedSpec::SPEC_SHA256)->toMatch('/^[0-9a-f]{64}$/')
        ->and(hash_file('sha256', repoRoot() . '/.esi/openapi.yaml'))
        ->toBe(GeneratedSpec::SPEC_SHA256);
});

it('names the header a transport must send', function (): void {
    expect(GeneratedSpec::COMPATIBILITY_DATE_HEADER)->toBe('X-Compatibility-Date');
});

/**
 * The orphan guard. bin/generate.php used to write without ever deleting, so
 * classes for endpoints CCP removed accumulated silently — four of them had, and
 * removals were invisible to any diff. If a stale file reappears under
 * src/Responses or src/Resources, these counts stop matching.
 */
it('counts match what is actually on disk', function (): void {
    $dtos     = glob(repoRoot() . '/src/Responses/*.php') ?: [];
    $routes   = glob(repoRoot() . '/src/Resources/*/*.php') ?: [];
    $wrappers = glob(repoRoot() . '/src/Resources/*Resource.php') ?: [];

    expect($dtos)->toHaveCount(GeneratedSpec::DTO_COUNT)
        ->and($routes)->toHaveCount(GeneratedSpec::ROUTE_COUNT)
        ->and($wrappers)->toHaveCount(GeneratedSpec::WRAPPER_COUNT);
});

it('agrees with the counts recorded in .esi/state.json', function (): void {
    $counts = esiState()['counts'];

    expect($counts)->toBeArray()
        ->and($counts['dtos'])->toBe(GeneratedSpec::DTO_COUNT)
        ->and($counts['routes'])->toBe(GeneratedSpec::ROUTE_COUNT)
        ->and($counts['wrappers'])->toBe(GeneratedSpec::WRAPPER_COUNT);
});

it('surface manifest hash recorded in state matches the manifest file', function (): void {
    $manifest = file_get_contents(repoRoot() . '/.esi/surface.json');
    expect($manifest)->not->toBeFalse();

    expect(hash('sha256', (string) $manifest))->toBe(esiState()['surface_sha256']);
});

/**
 * The manifest is the release authority, so it must not contain the compatibility
 * date or the spec hash. If GeneratedSpec's constants leaked into it, the hash
 * would flip on every cosmetic spec edit and a date-only advance could never be
 * distinguished from a real API change.
 */
it('surface manifest excludes GeneratedSpec and carries no date or spec hash', function (): void {
    $manifest = (string) file_get_contents(repoRoot() . '/.esi/surface.json');

    expect($manifest)->not->toContain('GeneratedSpec')
        ->and($manifest)->not->toContain(GeneratedSpec::COMPATIBILITY_DATE)
        ->and($manifest)->not->toContain(GeneratedSpec::SPEC_SHA256);
});

/**
 * The #81 guard, from the manifest side.
 *
 * `EsiResult<null>` is correct for an endpoint that returns nothing and a silent
 * bug for one that declares a body — the two are indistinguishable in the emitted
 * code, which is why a dropped payload survived two regenerations. So pin the set
 * rather than a pattern: these 20 are every operation in the document with no 2xx
 * `application/json` body. An operation that quietly stops mapping its payload
 * joins this list and fails here, whatever its HTTP verb.
 *
 * A verb heuristic cannot do this job — 6 of the 20 legitimate voids are POSTs,
 * and 7 of the 8 operations #81 repaired were POSTs too.
 *
 * Adding a name here is a deliberate act: it asserts CCP really did drop the body.
 */
it('only endpoints with no declared response body return EsiResult<null>', function (): void {
    /** @var array{symbols: list<string>} $surface */
    $surface = json_decode(
        (string) file_get_contents(repoRoot() . '/.esi/surface.json'),
        true,
        512,
        JSON_THROW_ON_ERROR,
    );

    $void = [];
    foreach ($surface['symbols'] as $symbol) {
        if (! str_contains($symbol, '[@return EsiResult<null>]')) {
            continue;
        }
        if (preg_match('/^method \S+\\\\Resources\\\\\w+\\\\(\w+)::execute\(/', $symbol, $match) === 1) {
            $void[] = $match[1];
        }
    }
    sort($void);

    expect($void)->toBe([
        'DeleteCharactersCharacterIdContacts',
        'DeleteCharactersCharacterIdFittingsFittingId',
        'DeleteCharactersCharacterIdMailLabelsLabelId',
        'DeleteCharactersCharacterIdMailMailId',
        'DeleteFleetsFleetIdMembersMemberId',
        'DeleteFleetsFleetIdSquadsSquadId',
        'DeleteFleetsFleetIdWingsWingId',
        'PostFleetsFleetIdMembers',
        'PostUiAutopilotWaypoint',
        'PostUiOpenwindowContract',
        'PostUiOpenwindowInformation',
        'PostUiOpenwindowMarketdetails',
        'PostUiOpenwindowNewmail',
        'PutCharactersCharacterIdCalendarEventId',
        'PutCharactersCharacterIdContacts',
        'PutCharactersCharacterIdMailMailId',
        'PutFleetsFleetId',
        'PutFleetsFleetIdMembersMemberId',
        'PutFleetsFleetIdSquadsSquadId',
        'PutFleetsFleetIdWingsWingId',
    ]);
});

it('every generated file is represented in the surface manifest', function (): void {
    /** @var array{symbols: list<string>} $surface */
    $surface = json_decode(
        (string) file_get_contents(repoRoot() . '/.esi/surface.json'),
        true,
        512,
        JSON_THROW_ON_ERROR,
    );

    $classSymbols = array_filter($surface['symbols'], static fn (string $s): bool => str_starts_with($s, 'class '));

    expect($classSymbols)->toHaveCount(
        GeneratedSpec::DTO_COUNT + GeneratedSpec::ROUTE_COUNT + GeneratedSpec::WRAPPER_COUNT,
    );
});
