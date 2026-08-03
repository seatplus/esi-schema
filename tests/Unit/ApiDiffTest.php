<?php

declare(strict_types=1);

/**
 * bin/api-diff.php decides what gets published. A bug in it that under-reports
 * ships a removed property as a patch to every consumer on the next
 * `composer update`, and a Packagist tag cannot be withdrawn. So every rule gets a
 * fixture, and the bias is asserted explicitly: unrecognised input must escalate,
 * never resolve to a harmless-looking verdict.
 */
function runApiDiff(array $oldSymbols, array $newSymbols, string $format = 'json'): array
{
    $dir = sys_get_temp_dir() . '/api-diff-' . bin2hex(random_bytes(6));
    mkdir($dir);

    $write = static function (string $path, array $symbols): void {
        file_put_contents($path, json_encode(
            ['schemaVersion' => 1, 'symbols' => $symbols],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES,
        ));
    };

    $write("{$dir}/old.json", $oldSymbols);
    $write("{$dir}/new.json", $newSymbols);

    $script = dirname(__DIR__, 2) . '/bin/api-diff.php';
    $command = sprintf(
        'php %s --old=%s --new=%s --format=%s 2>&1',
        escapeshellarg($script),
        escapeshellarg("{$dir}/old.json"),
        escapeshellarg("{$dir}/new.json"),
        escapeshellarg($format),
    );

    $output   = [];
    $exitCode = 0;
    exec($command, $output, $exitCode);

    array_map('unlink', glob("{$dir}/*.json") ?: []);
    rmdir($dir);

    return ['stdout' => implode("\n", $output), 'exit' => $exitCode];
}

function bumpFor(array $oldSymbols, array $newSymbols): string
{
    $result = runApiDiff($oldSymbols, $newSymbols, 'bump');

    return trim($result['stdout']);
}

// --- no change -------------------------------------------------------------

it('reports no change for identical manifests', function (): void {
    $symbols = ['class A\B', 'prop A\B::$x int required'];

    expect(bumpFor($symbols, $symbols))->toBe('none');
});

// --- removals are always major --------------------------------------------

it('classifies a removed class as major', function (): void {
    expect(bumpFor(['class A\B', 'class A\C'], ['class A\B']))->toBe('major');
});

it('classifies a removed property as major', function (): void {
    expect(bumpFor(
        ['class A\B', 'prop A\B::$x int required'],
        ['class A\B'],
    ))->toBe('major');
});

it('classifies a removed method as major', function (): void {
    expect(bumpFor(
        ['class A\B', 'method A\B::go(int $id): void'],
        ['class A\B'],
    ))->toBe('major');
});

it('classifies a removed constant as major', function (): void {
    expect(bumpFor(
        ['class A\B', 'const A\B::CACHE_AGE ?int = 60'],
        ['class A\B'],
    ))->toBe('major');
});

// --- additions are minor ---------------------------------------------------

it('classifies a new class as minor', function (): void {
    expect(bumpFor(['class A\B'], ['class A\B', 'class A\C']))->toBe('minor');
});

it('classifies a new property as minor', function (): void {
    expect(bumpFor(
        ['class A\B'],
        ['class A\B', 'prop A\B::$x ?int optional'],
    ))->toBe('minor');
});

// --- property type changes ------------------------------------------------

it('treats a property gaining nullability as major', function (): void {
    // These DTOs are outputs. Every reader of $dto->x can now receive null.
    expect(bumpFor(
        ['class A\B', 'prop A\B::$x string required'],
        ['class A\B', 'prop A\B::$x ?string optional'],
    ))->toBe('major');
});

it('treats a property losing nullability as minor', function (): void {
    expect(bumpFor(
        ['class A\B', 'prop A\B::$x ?string optional'],
        ['class A\B', 'prop A\B::$x string required'],
    ))->toBe('minor');
});

it('treats a retyped property as major', function (): void {
    expect(bumpFor(
        ['class A\B', 'prop A\B::$x float required'],
        ['class A\B', 'prop A\B::$x A\Taxrates required'],
    ))->toBe('major');
});

it('treats a property becoming required as minor when the type is unchanged', function (): void {
    // Constructor argument order is not part of the contract: DTOs are built by
    // ::from() or with named arguments. Reader-safe.
    expect(bumpFor(
        ['class A\B', 'prop A\B::$x ?int optional'],
        ['class A\B', 'prop A\B::$x ?int required'],
    ))->toBe('minor');
});

// --- constant value changes -----------------------------------------------

it('treats a metadata constant value change as patch', function (): void {
    expect(bumpFor(
        ['class A\B', 'const A\B::CACHE_AGE ?int = 0'],
        ['class A\B', 'const A\B::CACHE_AGE ?int = null'],
    ))->toBe('patch');
});

it('treats a REQUIRED_SCOPE change as minor, not major', function (): void {
    expect(bumpFor(
        ["class A\B", "const A\B::REQUIRED_SCOPE ?string = 'esi-old.v1'"],
        ["class A\B", "const A\B::REQUIRED_SCOPE ?string = 'esi-new.v1'"],
    ))->toBe('minor');
});

it('surfaces a REQUIRED_SCOPE change as a note so it reaches the release notes', function (): void {
    $result = runApiDiff(
        ["class A\B", "const A\B::REQUIRED_SCOPE ?string = 'esi-old.v1'"],
        ["class A\B", "const A\B::REQUIRED_SCOPE ?string = 'esi-new.v1'"],
    );

    expect($result['stdout'])->toContain('const.requiredScopeChanged');
});

it('treats a newly required in-game role as major', function (): void {
    expect(bumpFor(
        ['class A\B', 'const A\B::REQUIRED_ROLES array = []'],
        ["class A\B", "const A\B::REQUIRED_ROLES array = ['Director']"],
    ))->toBe('major');
});

it('treats a dropped in-game role as minor', function (): void {
    expect(bumpFor(
        ["class A\B", "const A\B::REQUIRED_ROLES array = ['Director']"],
        ['class A\B', 'const A\B::REQUIRED_ROLES array = []'],
    ))->toBe('minor');
});

it('treats a retyped constant as major even for metadata', function (): void {
    expect(bumpFor(
        ['class A\B', 'const A\B::CACHE_AGE ?int = 60'],
        ["class A\B", "const A\B::CACHE_AGE ?string = '60'"],
    ))->toBe('major');
});

// --- method signature changes ---------------------------------------------

it('treats an appended optional parameter as minor', function (): void {
    expect(bumpFor(
        ['class A\B', 'method A\B::go(int $id): void'],
        ['class A\B', 'method A\B::go(int $id, int $page = 1): void'],
    ))->toBe('minor');
});

it('treats an appended required parameter as major', function (): void {
    // The grep cross-check cannot see this: it is a '+' line with no '-'.
    expect(bumpFor(
        ['class A\B', 'method A\B::go(int $id): void'],
        ['class A\B', 'method A\B::go(int $id, int $page): void'],
    ))->toBe('major');
});

it('treats a reordered parameter list as major', function (): void {
    expect(bumpFor(
        ['class A\B', 'method A\B::go(int $id, string $name): void'],
        ['class A\B', 'method A\B::go(string $name, int $id): void'],
    ))->toBe('major');
});

it('treats a changed return type as major', function (): void {
    expect(bumpFor(
        ['class A\B', 'method A\B::go(int $id): Foo'],
        ['class A\B', 'method A\B::go(int $id): Bar'],
    ))->toBe('major');
});

it('treats a changed @return generic as major', function (): void {
    // The payload type of ~140 operations lives only in this docblock generic, so
    // a manifest built by reflection would miss this entirely.
    expect(bumpFor(
        ['class A\B', 'method A\B::execute(T $t): EsiResult [@return EsiResult<array<int>>]'],
        ['class A\B', 'method A\B::execute(T $t): EsiResult [@return EsiResult<array<string>>]'],
    ))->toBe('major');
});

// --- fail-safe behaviour --------------------------------------------------

it('escalates to undecidable on an unrecognised symbol form', function (): void {
    $result = runApiDiff(['class A\B'], ['class A\B', 'wat is this even']);

    expect($result['exit'])->toBe(2)
        ->and($result['stdout'])->toContain('unrecognised symbol form');
});

it('escalates to undecidable on a manifest schema version it does not know', function (): void {
    $dir = sys_get_temp_dir() . '/api-diff-' . bin2hex(random_bytes(6));
    mkdir($dir);
    file_put_contents("{$dir}/old.json", json_encode(['schemaVersion' => 99, 'symbols' => []]));
    file_put_contents("{$dir}/new.json", json_encode(['schemaVersion' => 1, 'symbols' => []]));

    $output   = [];
    $exitCode = 0;
    exec(sprintf(
        'php %s --old=%s --new=%s 2>&1',
        escapeshellarg(dirname(__DIR__, 2) . '/bin/api-diff.php'),
        escapeshellarg("{$dir}/old.json"),
        escapeshellarg("{$dir}/new.json"),
    ), $output, $exitCode);

    array_map('unlink', glob("{$dir}/*.json") ?: []);
    rmdir($dir);

    expect($exitCode)->toBe(2);
});

it('escalates to undecidable when the baseline manifest is missing', function (): void {
    $output   = [];
    $exitCode = 0;
    exec(sprintf(
        'php %s --old=%s --new=%s 2>&1',
        escapeshellarg(dirname(__DIR__, 2) . '/bin/api-diff.php'),
        escapeshellarg('/nonexistent/old.json'),
        escapeshellarg(dirname(__DIR__, 2) . '/.esi/surface.json'),
    ), $output, $exitCode);

    expect($exitCode)->toBe(2);
});

// --- the golden test ------------------------------------------------------

it('classifies the real 2026-05-19 to 2026-07-21 transition as major', function (): void {
    $fixtures = dirname(__DIR__) . '/Fixtures/surface';

    $output   = [];
    $exitCode = 0;
    exec(sprintf(
        'php %s --old=%s --new=%s --format=json 2>&1',
        escapeshellarg(dirname(__DIR__, 2) . '/bin/api-diff.php'),
        escapeshellarg("{$fixtures}/2026-05-19.json"),
        escapeshellarg("{$fixtures}/2026-07-21.json"),
    ), $output, $exitCode);

    expect($exitCode)->toBe(0);

    /** @var array{bump: string, breaking: list<array{rule: string, subject: string}>} $verdict */
    $verdict  = json_decode(implode("\n", $output), true, 512, JSON_THROW_ON_ERROR);
    $subjects = array_column($verdict['breaking'], 'subject');

    expect($verdict['bump'])->toBe('major');

    // The five breaks that sat unreviewed under 505 files of docblock churn.
    expect($subjects)->toContain('class Seatplus\EsiSchema\Resources\Character\GetCharactersCharacterId')
        ->and($subjects)->toContain('method Seatplus\EsiSchema\Resources\CharacterResource::getCharactersCharacterId')
        ->and($subjects)->toContain('prop Seatplus\EsiSchema\Responses\CharactersDetail::$title')
        ->and($subjects)->toContain('prop Seatplus\EsiSchema\Responses\CorporationsDetail::$tax_rate')
        ->and($subjects)->toContain('prop Seatplus\EsiSchema\Responses\CorporationsDetail::$ceo_id');
});

it('reports no change when a manifest is compared against itself', function (): void {
    $fixtures = dirname(__DIR__) . '/Fixtures/surface';

    $output   = [];
    $exitCode = 0;
    exec(sprintf(
        'php %s --old=%s --new=%s --format=bump 2>&1',
        escapeshellarg(dirname(__DIR__, 2) . '/bin/api-diff.php'),
        escapeshellarg("{$fixtures}/2026-07-21.json"),
        escapeshellarg("{$fixtures}/2026-07-21.json"),
    ), $output, $exitCode);

    expect(trim(implode('', $output)))->toBe('none');
});
