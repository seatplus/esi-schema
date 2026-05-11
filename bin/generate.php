#!/usr/bin/env php
<?php

/**
 * ESI Schema Generator — OpenAPI 3.1.0 edition
 *
 * Fetches the ESI OpenAPI YAML spec and generates:
 *   - src/Responses/{SchemaName}.php   (item DTOs, one per schema object)
 *
 * All generated classes extend AbstractEsiDto which carries $isCachedLoad and $pages.
 *
 * Usage:
 *   php bin/generate.php [--compatibility-date=2025-12-16] [--spec=/path/to/openapi.yaml] [--dry-run]
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

// ---------------------------------------------------------------------------
// CLI args
// ---------------------------------------------------------------------------

$args = [];
foreach (array_slice($argv, 1) as $arg) {
    if (str_starts_with($arg, '--')) {
        [$k, $v] = explode('=', ltrim($arg, '-'), 2) + [1 => 'true'];
        $args[$k] = $v;
    }
}

$dryRun = isset($args['dry-run']);
$specFile = $args['spec'] ?? null;

// ---------------------------------------------------------------------------
// Fetch compatibility dates and spec
// ---------------------------------------------------------------------------

$COMPAT_DATE_URL = 'https://esi.evetech.net/meta/compatibility-dates';
$SPEC_BASE_URL   = 'https://esi.evetech.net/meta/openapi.yaml';

if (isset($args['compatibility-date'])) {
    $compatDate = $args['compatibility-date'];
} else {
    echo "Fetching compatibility dates...\n";
    $datesJson = file_get_contents($COMPAT_DATE_URL);
    $dates = json_decode($datesJson, true)['compatibility_dates'] ?? [];
    $compatDate = $dates[0] ?? '2025-12-16'; // first = latest
    echo "Using compatibility_date: {$compatDate}\n";
}

if ($specFile) {
    echo "Loading spec from file: {$specFile}\n";
    $rawSpec = file_get_contents($specFile);
} else {
    $specUrl = "{$SPEC_BASE_URL}?compatibility_date={$compatDate}";
    echo "Fetching spec from {$specUrl}...\n";
    $rawSpec = file_get_contents($specUrl);
}

$spec = Yaml::parse($rawSpec);
$schemas = $spec['components']['schemas'] ?? [];
$paths   = $spec['paths'] ?? [];

define('ESI_COMPATIBILITY_DATE', $compatDate);

// ---------------------------------------------------------------------------
// Output directory
// ---------------------------------------------------------------------------

$responsesDir = __DIR__ . '/../src/Responses';

// ---------------------------------------------------------------------------
// Helper: convert OAS3 type/format to PHP type
// ---------------------------------------------------------------------------

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

/**
 * Return a PHP zero/fallback value expression for a given PHP type.
 * Used in defensive from() — required fields use ?? fallback to survive
 * CCP stealth changes that remove fields without bumping the compatibility date.
 */
function phpTypeZeroValue(string $phpType): string
{
    return match ($phpType) {
        'int'    => '0',
        'float'  => '0.0',
        'bool'   => 'false',
        'string' => "''",
        'array'  => '[]',
        default  => 'null',
    };
}

// ---------------------------------------------------------------------------
// Helper: resolve a $ref string to a PHP type (or class name if object)
// ---------------------------------------------------------------------------

/** @var array<string,string> $commonModelTypes  schemaName → 'int'|'string'|'float' */
$commonModelTypes = [];

foreach ($schemas as $name => $schema) {
    if ($schema['x-common-model'] ?? false) {
        $commonModelTypes[$name] = oas3TypeToPhp($schema);
    }
}

function resolveRef(string $ref, array $commonModelTypes): string
{
    $name = basename(str_replace('#/components/schemas/', '', $ref));
    return $commonModelTypes[$name] ?? $name;
}

// ---------------------------------------------------------------------------
// Helper: determine PHP type for a schema property
// ---------------------------------------------------------------------------

function propToPhpType(array $prop, array $commonModelTypes, array $schemas): string
{
    if (isset($prop['$ref'])) {
        return resolveRef($prop['$ref'], $commonModelTypes);
    }

    $type = $prop['type'] ?? 'mixed';

    if ($type === 'array') {
        return 'array';
    }

    return oas3TypeToPhp($prop);
}

// ---------------------------------------------------------------------------
// Generate a DTO class for an object schema
// ---------------------------------------------------------------------------

function generateDtoClass(
    string $className,
    array $properties,
    array $required,
    array $commonModelTypes,
    array $schemas,
    string $suffix = ''
): string {
    $requiredSet = array_flip($required);

    $requiredProps = [];
    $optionalProps = [];
    foreach ($properties as $propName => $prop) {
        if (isset($requiredSet[$propName])) {
            $requiredProps[$propName] = $prop;
        } else {
            $optionalProps[$propName] = $prop;
        }
    }

    $constructorLines = [];
    $fromLines        = [];
    $useStatements    = [];

    foreach ($requiredProps as $propName => $prop) {
        $phpType = propToPhpType($prop, $commonModelTypes, $schemas);
        if (! in_array($phpType, ['int', 'float', 'bool', 'string', 'array', 'mixed'], true)) {
            $useStatements[] = "use Seatplus\\EsiSchema\\Responses\\{$phpType};";
        }
        $constructorLines[] = "        public readonly {$phpType} \${$propName},";

        if ($phpType === 'array') {
            $items = $prop['items'] ?? [];
            if (isset($items['$ref'])) {
                $itemClass = resolveRef($items['$ref'], $commonModelTypes);
                if (! in_array($itemClass, ['int', 'float', 'bool', 'string'], true)) {
                    $useStatements[] = "use Seatplus\\EsiSchema\\Responses\\{$itemClass};";
                    $fromLines[] = "            {$propName}: array_map(fn(object \$i) => {$itemClass}::from(\$i), (array) (\$data->{$propName} ?? [])),";
                } else {
                    $fromLines[] = "            {$propName}: (array) (\$data->{$propName} ?? []),";
                }
            } else {
                $fromLines[] = "            {$propName}: (array) (\$data->{$propName} ?? []),";
            }
        } elseif (! in_array($phpType, ['int', 'float', 'bool', 'string', 'array', 'mixed'], true)) {
            $fromLines[] = "            {$propName}: {$phpType}::from(\$data->{$propName} ?? new \\stdClass()),";
        } else {
            $zero = phpTypeZeroValue($phpType);
            $cast = $phpType !== 'mixed' ? "({$phpType}) " : '';
            $fromLines[] = "            {$propName}: {$cast}(\$data->{$propName} ?? {$zero}),";
        }
    }

    foreach ($optionalProps as $propName => $prop) {
        $phpType = propToPhpType($prop, $commonModelTypes, $schemas);
        if (! in_array($phpType, ['int', 'float', 'bool', 'string', 'array', 'mixed'], true)) {
            $useStatements[] = "use Seatplus\\EsiSchema\\Responses\\{$phpType};";
        }
        if ($phpType === 'array') {
            $constructorLines[] = "        public readonly ?array \${$propName} = null,";
            $fromLines[] = "            {$propName}: isset(\$data->{$propName}) ? (array) \$data->{$propName} : null,";
        } elseif (! in_array($phpType, ['int', 'float', 'bool', 'string', 'array', 'mixed'], true)) {
            $constructorLines[] = "        public readonly ?{$phpType} \${$propName} = null,";
            $fromLines[] = "            {$propName}: isset(\$data->{$propName}) ? {$phpType}::from(\$data->{$propName}) : null,";
        } elseif ($phpType === 'mixed') {
            $constructorLines[] = "        public readonly mixed \${$propName} = null,";
            $fromLines[] = "            {$propName}: \$data->{$propName} ?? null,";
        } else {
            $constructorLines[] = "        public readonly ?{$phpType} \${$propName} = null,";
            $fromLines[] = "            {$propName}: \$data->{$propName} ?? null,";
        }
    }

    $constructorBlock = implode("\n", $constructorLines);
    $fromBlock        = implode("\n", $fromLines);
    $useBlock         = empty($useStatements)
        ? ''
        : "\n" . implode("\n", array_unique($useStatements)) . "\n";

    $fullName   = $className . $suffix;
    $compatDate = ESI_COMPATIBILITY_DATE;

    return <<<PHP
    <?php

    namespace Seatplus\\EsiSchema\\Responses;

    use Seatplus\\EsiSchema\\AbstractEsiDto;
    {$useBlock}
    /**
     * Generated from ESI OpenAPI spec (compatibility date: {$compatDate}).
     * Do not edit manually — run bin/generate.php instead.
     */
    final class {$fullName} extends AbstractEsiDto
    {
        public function __construct(
    {$constructorBlock}
        ) {}

        public static function from(object \$data): static
        {
            return new static(
    {$fromBlock}
            );
        }
    }
    PHP;
}

// ---------------------------------------------------------------------------
// Collect all DTOs to generate
// ---------------------------------------------------------------------------

/** @var array<string, string> $dtoFiles  className → PHP source */
$dtoFiles = [];

foreach ($schemas as $name => $schema) {
    if ($schema['x-common-model'] ?? false) {
        continue;
    }

    $type = $schema['type'] ?? null;

    if ($type === 'object') {
        $props    = $schema['properties'] ?? [];
        $required = $schema['required'] ?? [];
        $dtoFiles[$name] = generateDtoClass($name, $props, $required, $commonModelTypes, $schemas);
    } elseif ($type === 'array') {
        $items = $schema['items'] ?? [];
        if (($items['type'] ?? '') === 'object') {
            $itemClass = $name . 'Item';
            $props     = $items['properties'] ?? [];
            $required  = $items['required'] ?? [];
            $dtoFiles[$itemClass] = generateDtoClass($itemClass, $props, $required, $commonModelTypes, $schemas);
        }
        // primitive arrays need no DTO
    }
    // primitives need no DTO
}

// ---------------------------------------------------------------------------
// Write files
// ---------------------------------------------------------------------------

$writtenFiles = 0;

if (! $dryRun) {
    if (! is_dir($responsesDir)) {
        mkdir($responsesDir, 0755, true);
    }

    foreach ($dtoFiles as $className => $source) {
        $file = "{$responsesDir}/{$className}.php";
        file_put_contents($file, $source);
        echo "  wrote: src/Responses/{$className}.php\n";
        $writtenFiles++;
    }
} else {
    foreach ($dtoFiles as $className => $source) {
        echo "  [dry-run] would write: src/Responses/{$className}.php\n";
        $writtenFiles++;
    }
}

echo "\nDone. {$writtenFiles} DTO files " . ($dryRun ? 'would be written' : 'written') . ".\n";
