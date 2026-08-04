<?php

declare(strict_types=1);

/**
 * Schema → PHP type resolution for the generator.
 *
 * These live outside bin/generate.php so they can be unit-tested. The generator
 * spine cannot be driven from a test — it hardcodes its output paths, refuses an
 * implausible spec and prunes src/ — but nothing here touches the filesystem or
 * the CLI, so every response shape can be asserted from a fixture instead of
 * being verified by eye against 219 regenerated files.
 */

// ---------------------------------------------------------------------------
// Helper: convert OAS3 type/format to PHP type
// ---------------------------------------------------------------------------

/** @param array<mixed> $prop */
function oas3TypeToPhp(array $prop): string
{
    $type = $prop['type'] ?? 'mixed';

    return match (true) {
        $type === 'integer' => 'int',
        $type === 'number'  => 'float',
        $type === 'boolean' => 'bool',
        $type === 'string'  => 'string',
        $type === 'array'   => 'array',
        default             => 'mixed',
    };
}

/** @param array<string,string> $commonModelTypes */
function resolveRef(string $ref, array $commonModelTypes): string
{
    $name = basename(str_replace('#/components/schemas/', '', $ref));

    return $commonModelTypes[$name] ?? $name;
}

// ---------------------------------------------------------------------------
// Response shape
// ---------------------------------------------------------------------------

/**
 * Pick the response that carries an operation's payload.
 *
 * The lowest 2xx with a non-empty `application/json` schema, not a hardcoded
 * '200': a body declared under 201 is just as real, and seven POSTs declare
 * theirs there. "Non-empty" matters too — GetContractsPublicBidsContractId and
 * GetContractsPublicItemsContractId declare a 204 with `schema: {}`, which is a
 * body-less response spelled the long way, not a payload we failed to type.
 *
 * @param  array<mixed> $responses an operation's `responses` object
 * @return array{0: array<mixed>, 1: string|null} the response object, and its status code
 */
function selectSuccessResponse(array $responses): array
{
    $codes = array_filter(
        array_keys($responses),
        static fn (string|int $code): bool => preg_match('/^2\d\d$/', (string) $code) === 1,
    );
    sort($codes);

    foreach ($codes as $code) {
        $response = $responses[$code];
        if (! is_array($response)) {
            continue;
        }
        $schema = $response['content']['application/json']['schema'] ?? null;
        if (is_array($schema) && $schema !== []) {
            return [$response, (string) $code];
        }
    }

    return [[], null];
}

/**
 * Resolve an operation's success response into the values the emitters need.
 *
 * `responseType` is the tag buildReturn() matches on; `void` means "this
 * operation returns no payload". A `void` returned alongside a non-empty
 * `schema` is always a generator gap rather than a body-less endpoint — the
 * caller refuses to emit one.
 *
 * @param  array<mixed>         $op                a single OpenAPI operation object
 * @param  array<string, mixed> $schemas           components.schemas
 * @param  array<string,string> $commonModelTypes  schemaName → PHP scalar
 * @return array{responseType: string, dtoClass: string|null, phpDocReturn: string, primitiveType: string|null, schemaName: string|null, xPages: bool, schema: array<mixed>, statusCode: string|null}
 */
function resolveResponseShape(array $op, array $schemas, array $commonModelTypes): array
{
    [$response, $statusCode] = selectSuccessResponse($op['responses'] ?? []);

    /** @var array<mixed>|null $respSchema */
    $respSchema = $response['content']['application/json']['schema'] ?? null;
    $schemaRef  = $respSchema['$ref'] ?? null;
    $schemaName = $schemaRef ? basename(str_replace('#/components/schemas/', '', $schemaRef)) : null;
    $xPages     = isset($response['headers']['X-Pages']);

    // A body may be declared inline rather than behind a component $ref, in which
    // case the schema in front of us IS the schema. Only the skill queue does that
    // today, and reading it here is what stops a declared body from being silently
    // typed as null (issue #81).
    $schema        = $schemaName ? ($schemas[$schemaName] ?? []) : ($respSchema ?? []);
    $schemaType    = $schema['type'] ?? 'void';
    $responseType  = 'void';
    $dtoClass      = null;
    $phpDocReturn  = 'EsiResult<null>';
    $primitiveType = null;
    $primitivePhp  = null;

    if ($schema !== []) {
        // 'object' and array-of-inline-object both name their DTO after the
        // component ($schemaName, $schemaName . 'Item'), and that name exists only
        // because DTO emission derived it from the same component. An inline schema
        // has no such name and no emitted DTO, so it must not be invented here —
        // it falls through to void and the caller's guard reports it.
        if ($schemaType === 'object' && $schemaName !== null) {
            $responseType = 'object';
            $dtoClass     = $schemaName;
            $phpDocReturn = $schemaName;
        } elseif ($schemaType === 'array') {
            $items = $schema['items'] ?? [];
            if (isset($items['$ref'])) {
                $itemClass = resolveRef($items['$ref'], $commonModelTypes);
                if (in_array($itemClass, ['int', 'float', 'bool', 'string'], true)) {
                    // An x-common-model item ($ref → TypeID and friends) is a scalar,
                    // not a DTO; array_ref would emit int::from($item).
                    $primitiveType = $itemClass;
                    $responseType  = 'array_primitive';
                    $phpDocReturn  = "EsiResult<array<{$itemClass}>>";
                } else {
                    $responseType = 'array_ref';
                    $dtoClass     = $itemClass;
                    $phpDocReturn = "EsiResult<array<{$itemClass}>>";
                }
            } elseif (($items['type'] ?? '') === 'object' && $schemaName !== null) {
                $responseType = 'array_item';
                $dtoClass     = $schemaName . 'Item';
                $phpDocReturn = "EsiResult<array<{$schemaName}Item>>";
            } elseif (($items['type'] ?? '') !== 'object') {
                $primitiveType = oas3TypeToPhp($items);
                $responseType  = 'array_primitive';
                $phpDocReturn  = "EsiResult<array<{$primitiveType}>>";
            }
        } elseif ($schemaType !== 'void') {
            $responseType = 'primitive';
            $primitivePhp = oas3TypeToPhp($schema);
            $phpDocReturn = "EsiResult<{$primitivePhp}>";
        }
    }

    return [
        'responseType'  => $responseType,
        'dtoClass'      => $dtoClass,
        'phpDocReturn'  => $phpDocReturn,
        'primitiveType' => $primitiveType ?? ($primitivePhp ?? null),
        'schemaName'    => $schemaName,
        'xPages'        => $xPages,
        'schema'        => $schema,
        'statusCode'    => $statusCode,
    ];
}
