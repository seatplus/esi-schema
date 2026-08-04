<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/bin/lib/response-shape.php';

/**
 * The generator spine cannot be driven from a test — it hardcodes its output
 * paths, refuses an implausible spec and prunes src/ — so before response
 * resolution was extracted, the only way to check a response shape was to
 * regenerate 219 files and read them. That is how issue #81 went unnoticed
 * through two regenerations: the shape it got wrong exists exactly once in the
 * document, and the wrong answer (`data: null`) is indistinguishable from the
 * right answer for the 20 endpoints that genuinely return nothing.
 *
 * These rows include four shapes the ESI document does not contain today. Those
 * are the point: they are the ones no amount of regenerating can exercise.
 */

/**
 * @param  array<mixed> $responses
 * @return array<mixed>
 */
function shapeOf(array $responses, array $schemas = [], array $commonModelTypes = []): array
{
    return resolveResponseShape(['responses' => $responses], $schemas, $commonModelTypes);
}

/** @return array<mixed> */
function jsonResponse(string $code, array $schema, array $headers = []): array
{
    return [$code => ['content' => ['application/json' => ['schema' => $schema]]] + ($headers === [] ? [] : ['headers' => $headers])];
}

// ---------------------------------------------------------------------------
// Component $ref bodies — the shapes that already worked
// ---------------------------------------------------------------------------

it('types a $ref to an object component as a DTO', function (): void {
    $shape = shapeOf(
        jsonResponse('200', ['$ref' => '#/components/schemas/AllianceDetail']),
        ['AllianceDetail' => ['type' => 'object']],
    );

    expect($shape['responseType'])->toBe('object')
        ->and($shape['dtoClass'])->toBe('AllianceDetail')
        ->and($shape['phpDocReturn'])->toBe('AllianceDetail');
});

it('types a $ref to an array-of-inline-object component as an item DTO', function (): void {
    $shape = shapeOf(
        jsonResponse('200', ['$ref' => '#/components/schemas/CharactersBlueprintsGet']),
        ['CharactersBlueprintsGet' => ['type' => 'array', 'items' => ['type' => 'object']]],
    );

    expect($shape['responseType'])->toBe('array_item')
        ->and($shape['dtoClass'])->toBe('CharactersBlueprintsGetItem')
        ->and($shape['phpDocReturn'])->toBe('EsiResult<array<CharactersBlueprintsGetItem>>');
});

it('types a $ref to an array-of-scalar component as an array of primitives', function (): void {
    $shape = shapeOf(
        jsonResponse('200', ['$ref' => '#/components/schemas/ImplantsGet']),
        ['ImplantsGet' => ['type' => 'array', 'items' => ['type' => 'integer']]],
    );

    expect($shape['responseType'])->toBe('array_primitive')
        ->and($shape['primitiveType'])->toBe('int')
        ->and($shape['phpDocReturn'])->toBe('EsiResult<array<int>>');
});

it('types a $ref to a scalar component as a primitive, preserving number as float', function (): void {
    $shape = shapeOf(
        jsonResponse('200', ['$ref' => '#/components/schemas/WalletBalance']),
        ['WalletBalance' => ['type' => 'number']],
    );

    expect($shape['responseType'])->toBe('primitive')
        ->and($shape['primitiveType'])->toBe('float')
        ->and($shape['phpDocReturn'])->toBe('EsiResult<float>');
});

// ---------------------------------------------------------------------------
// Inline bodies — issue #81
// ---------------------------------------------------------------------------

it('types an inline array of $ref items, the shape issue #81 was about', function (): void {
    // Verbatim from GetCharactersCharacterIdSkillqueue: the only operation in the
    // document that declares its body inline rather than behind a component $ref.
    $shape = shapeOf(
        jsonResponse('200', [
            'items' => ['$ref' => '#/components/schemas/CharactersSkillqueueSkill'],
            'type'  => 'array',
        ]),
        ['CharactersSkillqueueSkill' => ['type' => 'object']],
    );

    expect($shape['responseType'])->toBe('array_ref')
        ->and($shape['dtoClass'])->toBe('CharactersSkillqueueSkill')
        ->and($shape['phpDocReturn'])->toBe('EsiResult<array<CharactersSkillqueueSkill>>')
        ->and($shape['schemaName'])->toBeNull();
});

it('types an inline array of scalars', function (): void {
    $shape = shapeOf(jsonResponse('200', ['type' => 'array', 'items' => ['type' => 'string']]));

    expect($shape['responseType'])->toBe('array_primitive')
        ->and($shape['primitiveType'])->toBe('string');
});

it('types an inline scalar', function (): void {
    $shape = shapeOf(jsonResponse('200', ['type' => 'integer']));

    expect($shape['responseType'])->toBe('primitive')
        ->and($shape['primitiveType'])->toBe('int');
});

/**
 * An x-common-model item is a PHP scalar, not a class. Left as array_ref it would
 * emit `int::from($item)`. Nothing in the document reaches this today — the
 * array_ref branch itself had never executed for any operation before #81 was
 * fixed — so this row is the only thing standing between that branch and a
 * syntax error the day CCP inlines an array of IDs.
 */
it('treats an inline array of x-common-model $ref items as scalars, not DTOs', function (): void {
    $shape = shapeOf(
        jsonResponse('200', ['type' => 'array', 'items' => ['$ref' => '#/components/schemas/TypeID']]),
        ['TypeID' => ['type' => 'integer', 'x-common-model' => true]],
        ['TypeID' => 'int'],
    );

    expect($shape['responseType'])->toBe('array_primitive')
        ->and($shape['dtoClass'])->toBeNull()
        ->and($shape['primitiveType'])->toBe('int')
        ->and($shape['phpDocReturn'])->toBe('EsiResult<array<int>>');
});

// ---------------------------------------------------------------------------
// Shapes that must stay void so the generator's guard reports them
// ---------------------------------------------------------------------------

/**
 * An inline object has no component name, and DTO emission names DTOs after
 * components — so there is no class to point at and inventing one would publish
 * an API name CCP never chose. Staying void is deliberate: the caller turns a
 * declared-but-untypeable body into a FATAL.
 */
it('refuses to name a DTO for an inline object body', function (): void {
    $shape = shapeOf(jsonResponse('200', ['type' => 'object', 'properties' => ['x' => ['type' => 'integer']]]));

    expect($shape['responseType'])->toBe('void')
        ->and($shape['dtoClass'])->toBeNull()
        ->and($shape['statusCode'])->toBe('200')   // declared → the guard fires
        ->and($shape['schema'])->not->toBe([]);
});

it('refuses to name a DTO for an inline array of inline objects', function (): void {
    $shape = shapeOf(jsonResponse('200', ['type' => 'array', 'items' => ['type' => 'object']]));

    expect($shape['responseType'])->toBe('void')
        ->and($shape['statusCode'])->toBe('200');
});

it('reports a dangling component $ref as a declared body it could not type', function (): void {
    $shape = shapeOf(jsonResponse('200', ['$ref' => '#/components/schemas/GoneAway']), []);

    expect($shape['responseType'])->toBe('void')
        ->and($shape['schemaName'])->toBe('GoneAway')
        ->and($shape['statusCode'])->toBe('200');
});

// ---------------------------------------------------------------------------
// Response selection
// ---------------------------------------------------------------------------

it('reads a body declared under 201, not only 200', function (): void {
    $shape = shapeOf(
        jsonResponse('201', ['$ref' => '#/components/schemas/FleetsFleetIdWingsPost']),
        ['FleetsFleetIdWingsPost' => ['type' => 'object']],
    );

    expect($shape['responseType'])->toBe('object')
        ->and($shape['dtoClass'])->toBe('FleetsFleetIdWingsPost')
        ->and($shape['statusCode'])->toBe('201');
});

/**
 * GetContractsPublicBidsContractId and GetContractsPublicItemsContractId declare
 * a 204 with `schema: {}` alongside their real 200. An empty schema is a
 * body-less response spelled the long way — if selection keyed on the mere
 * presence of a schema, it would pick the 204 and the guard would fail the build
 * on two healthy endpoints.
 */
it('skips an empty 2xx schema and keeps looking', function (): void {
    $responses = jsonResponse('200', ['$ref' => '#/components/schemas/ContractItems'])
        + jsonResponse('204', []);

    $shape = resolveResponseShape(
        ['responses' => $responses],
        ['ContractItems' => ['type' => 'array', 'items' => ['type' => 'object']]],
        [],
    );

    expect($shape['statusCode'])->toBe('200')
        ->and($shape['responseType'])->toBe('array_item');
});

it('treats an operation whose only 2xx schema is empty as body-less, not broken', function (): void {
    $shape = shapeOf(jsonResponse('204', []));

    expect($shape['responseType'])->toBe('void')
        ->and($shape['statusCode'])->toBeNull()   // nothing declared → the guard stays quiet
        ->and($shape['phpDocReturn'])->toBe('EsiResult<null>');
});

it('treats a write with no 2xx body as void', function (): void {
    $shape = shapeOf(['204' => ['description' => 'No content'], 'default' => ['description' => 'Error']]);

    expect($shape['responseType'])->toBe('void')
        ->and($shape['statusCode'])->toBeNull()
        ->and($shape['phpDocReturn'])->toBe('EsiResult<null>');
});

it('ignores the default error response when picking a body', function (): void {
    $shape = shapeOf([
        '204'     => ['description' => 'No content'],
        'default' => ['content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]]],
    ]);

    expect($shape['statusCode'])->toBeNull()
        ->and($shape['responseType'])->toBe('void');
});

it('picks the lowest 2xx when more than one carries a body', function (): void {
    $responses = jsonResponse('202', ['type' => 'integer']) + jsonResponse('200', ['type' => 'string']);

    $shape = resolveResponseShape(['responses' => $responses], [], []);

    expect($shape['statusCode'])->toBe('200')
        ->and($shape['primitiveType'])->toBe('string');
});

it('detects X-Pages on the selected response', function (): void {
    $paged = shapeOf(jsonResponse(
        '200',
        ['$ref' => '#/components/schemas/Assets'],
        ['X-Pages' => ['$ref' => '#/components/headers/XPages']],
    ), ['Assets' => ['type' => 'array', 'items' => ['type' => 'object']]]);

    $unpaged = shapeOf(
        jsonResponse('200', ['$ref' => '#/components/schemas/Assets']),
        ['Assets' => ['type' => 'array', 'items' => ['type' => 'object']]],
    );

    expect($paged['xPages'])->toBeTrue()
        ->and($unpaged['xPages'])->toBeFalse();
});
