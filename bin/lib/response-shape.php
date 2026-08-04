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
 * Resolve an operation's success response into the values the emitters need.
 *
 * `responseType` is the tag buildReturn() matches on; `void` means "this
 * operation returns no payload". A `void` accompanied by a non-empty
 * `schema` is always a generator gap rather than a body-less endpoint — see
 * the caller, which refuses to emit one.
 *
 * @param  array<mixed>         $op                a single OpenAPI operation object
 * @param  array<string, mixed> $schemas           components.schemas
 * @param  array<string,string> $commonModelTypes  schemaName → PHP scalar
 * @return array{responseType: string, dtoClass: string|null, phpDocReturn: string, primitiveType: string|null, schemaName: string|null, xPages: bool, schema: array<mixed>}
 */
function resolveResponseShape(array $op, array $schemas, array $commonModelTypes): array
{
    $resp200    = $op['responses']['200'] ?? [];
    $respSchema = $resp200['content']['application/json']['schema'] ?? null;
    $schemaRef  = $respSchema['$ref'] ?? null;
    $schemaName = $schemaRef ? basename(str_replace('#/components/schemas/', '', $schemaRef)) : null;
    $xPages     = isset($resp200['headers']['X-Pages']);

    $schema        = $schemaName ? ($schemas[$schemaName] ?? []) : [];
    $schemaType    = $schema['type'] ?? 'void';
    $responseType  = 'void';
    $dtoClass      = null;
    $phpDocReturn  = 'EsiResult<null>';
    $primitiveType = null;
    $primitivePhp  = null;

    if ($schemaName) {
        if ($schemaType === 'object') {
            $responseType = 'object';
            $dtoClass     = $schemaName;
            $phpDocReturn = $schemaName;
        } elseif ($schemaType === 'array') {
            $items = $schema['items'] ?? [];
            if (isset($items['$ref'])) {
                $itemClass    = resolveRef($items['$ref'], $commonModelTypes);
                $responseType = 'array_ref';
                $dtoClass     = $itemClass;
                $phpDocReturn = "EsiResult<array<{$itemClass}>>";
            } elseif (($items['type'] ?? '') === 'object') {
                $responseType = 'array_item';
                $dtoClass     = $schemaName . 'Item';
                $phpDocReturn = "EsiResult<array<{$schemaName}Item>>";
            } else {
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
        'schema'        => is_array($respSchema) ? $respSchema : [],
    ];
}
