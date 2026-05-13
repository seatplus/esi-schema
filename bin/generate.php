#!/usr/bin/env php
<?php

/**
 * ESI Schema Generator — OpenAPI 3.1.0 edition
 *
 * Fetches the ESI OpenAPI YAML spec and generates:
 *   - src/Responses/{SchemaName}.php     (item DTOs, one per object schema)
 *   - src/Resources/{Tag}Resource.php    (one resource per ESI tag group)
 *   - src/Operations/{OperationId}.php   (one class per ESI route, with meta() + execute())
 *
 * All DTOs extend AbstractEsiDto which carries $isCachedLoad and $pages.
 * All Resources extend AbstractResource which holds EsiTransportInterface.
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

$dryRun   = isset($args['dry-run']);
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
    $datesJson  = file_get_contents($COMPAT_DATE_URL);
    $dates      = json_decode($datesJson, true)['compatibility_dates'] ?? [];
    $compatDate = $dates[0] ?? '2025-12-16';
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

$spec    = Yaml::parse($rawSpec);
$schemas = $spec['components']['schemas'] ?? [];
$paths   = $spec['paths'] ?? [];

define('ESI_COMPATIBILITY_DATE', $compatDate);

// ---------------------------------------------------------------------------
// Output directories
// ---------------------------------------------------------------------------

$responsesDir   = __DIR__ . '/../src/Responses';
$resourcesDir   = __DIR__ . '/../src/Resources';
$operationsDir  = __DIR__ . '/../src/Operations';

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
// Common model types (x-common-model → PHP primitive)
// ---------------------------------------------------------------------------

/** @var array<string,string> $commonModelTypes schemaName → 'int'|'string'|'float' */
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
// DTO generator
// ---------------------------------------------------------------------------

function generateDtoClass(
    string $className,
    array $properties,
    array $required,
    array $commonModelTypes,
    array $schemas,
    string $suffix = ''
): string {
    $requiredSet  = array_flip($required);
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
// Resource generator helpers
// ---------------------------------------------------------------------------

function tagToResourceClass(string $tag): string
{
    return str_replace(' ', '', ucwords($tag)) . 'Resource';
}

function buildInvoke(array $op): string
{
    $path      = $op['path'];
    $method    = $op['httpMethod'];
    $uriData   = [];
    $queryData = [];

    foreach ($op['params'] as $param) {
        $name = lcfirst(str_replace('_', '', ucwords($param['name'], '_')));
        if (($param['in'] ?? '') === 'path') {
            $uriData[] = "'{$param['name']}' => \${$name}";
        } elseif (($param['in'] ?? '') === 'query') {
            $queryData[] = "'{$param['name']}' => \${$name}";
        }
    }

    $uriStr   = empty($uriData) ? '[]' : '[' . implode(', ', $uriData) . ']';
    $queryStr = empty($queryData) ? '[]' : '[' . implode(', ', $queryData) . ']';
    $bodyStr  = $op['requestBody'] ? '(array) $requestBody' : '[]';

    if ($op['requestBody'] || $method !== 'get') {
        return "\$this->transport->invoke('{$method}', '{$path}', {$uriStr}, {$queryStr}, {$bodyStr})";
    }

    return "\$this->transport->invoke('{$method}', '{$path}', {$uriStr}, {$queryStr})";
}

function buildReturn(array $op): string
{
    $invoke     = buildInvoke($op);
    $type       = $op['responseType'];
    $dto        = $op['dtoClass'];
    $primT      = $op['primitiveType'] ?? 'int';
    $methodName = $op['methodName'];

    return match ($type) {
        'object' => <<<PHP
                \$response = {$invoke};
                \$dto = {$dto}::from((object) \$response->data);
                \$dto->isCachedLoad = \$response->isCachedLoad;
                \$dto->pages = \$response->pages;
                \$dto->operationMeta = static::OPERATION_META['{$methodName}'] ?? null;
                return \$dto;
        PHP,

        'array_item', 'array_ref' => <<<PHP
                \$response = {$invoke};
                return EsiResult::fromRaw(\$response, array_map(
                    fn(object \$item) => {$dto}::from(\$item),
                    (array) \$response->data,
                ), static::OPERATION_META['{$methodName}'] ?? null);
        PHP,

        'array_primitive' => <<<PHP
                \$response = {$invoke};
                /** @var array<{$primT}> \$data */
                \$data = array_map(fn(mixed \$i) => ({$primT}) \$i, (array) \$response->data);
                return EsiResult::fromRaw(\$response, \$data, static::OPERATION_META['{$methodName}'] ?? null);
        PHP,

        'primitive' => <<<PHP
                \$response = {$invoke};
                /** @var {$primT} \$scalar */
                \$scalar = ({$primT}) \$response->data;
                return EsiResult::fromRaw(\$response, \$scalar, static::OPERATION_META['{$methodName}'] ?? null);
        PHP,

        default => <<<PHP
                \$response = {$invoke};
                return EsiResult::fromRaw(\$response, null, static::OPERATION_META['{$methodName}'] ?? null);
        PHP,
    };
}

function buildMethodSig(array $op): string
{
    $args = [];

    usort($op['params'], fn ($a, $b) => ($b['required'] ?? false) <=> ($a['required'] ?? false));

    foreach ($op['params'] as $param) {
        $name       = lcfirst(str_replace('_', '', ucwords($param['name'], '_')));
        $paramSchema = $param['schema'] ?? $param;
        if (isset($paramSchema['$ref'])) {
            $phpType = resolveRef($paramSchema['$ref'], $op['_commonModelTypes'] ?? []);
            if (! in_array($phpType, ['int', 'float', 'string', 'bool', 'array'], true)) {
                $phpType = 'mixed';
            }
        } else {
            $phpType = oas3TypeToPhp($paramSchema);
        }
        $required = $param['required'] ?? false;

        if ($name === 'page') {
            $args[] = 'int $page = 1';
        } elseif ($required) {
            $args[] = "{$phpType} \${$name}";
        } else {
            $args[] = "?{$phpType} \${$name} = null";
        }
    }

    if ($op['requestBody']) {
        $args = array_merge(['mixed $requestBody'], $args);
    }

    return implode(', ', $args);
}

function generateResourceFile(string $tag, array $ops): string
{
    $resourceClass = tagToResourceClass($tag);
    $compatDate    = ESI_COMPATIBILITY_DATE;

    $useStatements = [];
    $methods       = [];
    $metaEntries   = [];

    foreach ($ops as $op) {
        $sig  = buildMethodSig($op);
        $body = buildReturn($op);
        $doc  = "     * @return {$op['phpDocReturn']}";
        $auth = $op['isAuth'] ? "\n     * @scope " . implode(', ', $op['scopes']) : '';
        $paged = $op['xPages'] ? "\n     * @paginated Use \$page param to iterate pages." : '';

        if ($op['dtoClass'] && ! in_array($op['dtoClass'], ['int', 'float', 'bool', 'string'], true)) {
            $useStatements[] = "use Seatplus\\EsiSchema\\Responses\\{$op['dtoClass']};";
        }

        $returnHint = $op['responseType'] === 'object'
            ? ($op['dtoClass'] ?? 'mixed')
            : 'EsiResult';

        $methods[] = <<<PHP
            /**
        {$doc}{$auth}{$paged}
             */
            public function {$op['methodName']}({$sig}): {$returnHint}
            {
        {$body}
            }
        PHP;

        // Build OPERATION_META entry
        $cacheAge      = $op['cacheAge'] !== null ? (string) $op['cacheAge'] : 'null';
        $requiredRoles = empty($op['requiredRoles']) ? '[]' : "['" . implode("', '", $op['requiredRoles']) . "']";
        $cursor        = $op['cursor'] ? 'true' : 'false';
        $requiredScope = empty($op['scopes']) ? 'null' : "'" . $op['scopes'][0] . "'";

        if ($op['rateLimit'] !== null) {
            $rl = $op['rateLimit'];
            $rateLimitStr = sprintf(
                "['group' => '%s', 'max-tokens' => %d, 'window-size' => '%s']",
                $rl['group'],
                (int) $rl['max-tokens'],
                $rl['window-size'],
            );
        } else {
            $rateLimitStr = 'null';
        }

        $metaEntries[$op['methodName']] = sprintf(
            "        '%s' => ['cacheAge' => %s, 'rateLimit' => %s, 'requiredRoles' => %s, 'cursor' => %s, 'requiredScope' => %s]",
            $op['methodName'],
            $cacheAge,
            $rateLimitStr,
            $requiredRoles,
            $cursor,
            $requiredScope,
        );
    }

    $useBlock     = empty($useStatements) ? '' : implode("\n", array_unique($useStatements)) . "\n";
    $methodsBlock = implode("\n\n", $methods);
    $metaBlock    = implode(",\n", array_values($metaEntries));

    return <<<PHP
    <?php

    namespace Seatplus\\EsiSchema\\Resources;

    use Seatplus\\EsiSchema\\EsiResult;
    {$useBlock}
    /**
     * ESI tag: {$tag}
     *
     * Generated from ESI OpenAPI spec (compatibility date: {$compatDate}).
     * Do not edit manually — run bin/generate.php instead.
     */
    class {$resourceClass} extends AbstractResource
    {
        protected const array OPERATION_META = [
    {$metaBlock},
        ];

    {$methodsBlock}
    }
    PHP;
}

// ---------------------------------------------------------------------------
// Generator: per-route operation class
// ---------------------------------------------------------------------------

function generateOperationClass(array $op): string
{
    $compatDate  = ESI_COMPATIBILITY_DATE;
    $className   = ucfirst($op['methodName']);  // PascalCase operationId
    $sig         = buildMethodSig($op);
    $body        = buildReturn($op);
    $returnHint  = $op['responseType'] === 'object' ? ($op['dtoClass'] ?? 'mixed') : 'EsiResult';
    $doc         = "     * @return {$op['phpDocReturn']}";
    $auth        = $op['isAuth'] ? "\n     * @scope " . implode(', ', $op['scopes']) : '';
    $paged       = $op['xPages'] ? "\n     * @paginated Use \$page param to iterate pages." : '';

    // Meta array inline (same format as OPERATION_META entries, without the key)
    $cacheAge      = $op['cacheAge'] !== null ? (string) $op['cacheAge'] : 'null';
    $requiredRoles = empty($op['requiredRoles']) ? '[]' : "['" . implode("', '", $op['requiredRoles']) . "']";
    $cursor        = $op['cursor'] ? 'true' : 'false';
    $requiredScope = empty($op['scopes']) ? 'null' : "'" . $op['scopes'][0] . "'";

    if ($op['rateLimit'] !== null) {
        $rl = $op['rateLimit'];
        $rateLimitStr = sprintf(
            "['group' => '%s', 'max-tokens' => %d, 'window-size' => '%s']",
            $rl['group'],
            (int) $rl['max-tokens'],
            $rl['window-size'],
        );
    } else {
        $rateLimitStr = 'null';
    }

    $useStatements = ['use Seatplus\\EsiSchema\\Contracts\\EsiOperationInterface;'];
    $useStatements[] = 'use Seatplus\\EsiSchema\\Contracts\\EsiTransportInterface;';
    $useStatements[] = 'use Seatplus\\EsiSchema\\EsiResult;';
    $useStatements[] = 'use Seatplus\\EsiSchema\\OperationMeta;';

    if ($op['dtoClass'] && ! in_array($op['dtoClass'], ['int', 'float', 'bool', 'string'], true)) {
        $useStatements[] = "use Seatplus\\EsiSchema\\Responses\\{$op['dtoClass']};";
    }

    // Replace $this->transport with $transport in the body (operation classes are static)
    $staticBody = str_replace('$this->transport->invoke', '$transport->invoke', $body);
    // Replace static::OPERATION_META[...] references with self::META
    $staticBody = preg_replace("/static::OPERATION_META\['{$op['methodName']}'\] \?\? null/", 'self::META', $staticBody);

    $useBlock = implode("\n", array_unique($useStatements));

    return <<<PHP
    <?php

    declare(strict_types=1);

    namespace Seatplus\\EsiSchema\\Operations;

    {$useBlock}

    /**
     * ESI operation: {$op['methodName']}
     *
     * Generated from ESI OpenAPI spec (compatibility date: {$compatDate}).
     * Do not edit manually — run bin/generate.php instead.
     */
    final class {$className} implements EsiOperationInterface
    {
        /** @var array<string,mixed> */
        private const array META = ['cacheAge' => {$cacheAge}, 'rateLimit' => {$rateLimitStr}, 'requiredRoles' => {$requiredRoles}, 'cursor' => {$cursor}, 'requiredScope' => {$requiredScope}];

        public static function meta(): OperationMeta
        {
            return OperationMeta::from(self::META);
        }

        /**
    {$doc}{$auth}{$paged}
         */
        public static function execute(EsiTransportInterface \$transport, {$sig}): {$returnHint}
        {
    {$staticBody}
        }
    }
    PHP;
}

// ---------------------------------------------------------------------------
// Build tag → operations map
// ---------------------------------------------------------------------------

$SKIP_PARAMS = ['AcceptLanguage', 'IfNoneMatch', 'CompatibilityDate', 'Tenant', 'IfModifiedSince'];

/** @var array<string, array<array<mixed>>> $tagOps */
$tagOps = [];

foreach ($paths as $path => $pathItem) {
    foreach ($pathItem as $httpMethod => $op) {
        if (! is_array($op) || ! isset($op['operationId'])) {
            continue;
        }

        $tag        = str_replace(' ', '', ucwords($op['tags'][0] ?? 'Unknown'));
        $methodName = lcfirst($op['operationId']);

        $params = [];
        foreach ($op['parameters'] ?? [] as $param) {
            if (isset($param['$ref'])) {
                $paramName = basename(str_replace('#/components/parameters/', '', $param['$ref']));
                if (in_array($paramName, $SKIP_PARAMS, true)) {
                    continue;
                }
                continue;
            }
            $params[] = $param;
        }

        $requestBody = null;
        $rbSchema    = $op['requestBody']['content']['application/json']['schema'] ?? null;
        if ($rbSchema) {
            $requestBody = $rbSchema;
        }

        $isAuth = ! empty($op['security']);
        $scopes = $op['security'][0]['OAuth2'] ?? [];

        $resp200    = $op['responses']['200'] ?? [];
        $respSchema = $resp200['content']['application/json']['schema'] ?? null;
        $schemaRef  = $respSchema['$ref'] ?? null;
        $schemaName = $schemaRef ? basename(str_replace('#/components/schemas/', '', $schemaRef)) : null;
        $xPages     = isset($resp200['headers']['X-Pages']);

        $schema       = $schemaName ? ($schemas[$schemaName] ?? []) : [];
        $schemaType   = $schema['type'] ?? 'void';
        $responseType = 'void';
        $dtoClass     = null;
        $phpDocReturn = 'EsiResult<null>';
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

        $tagOps[$tag][] = [
            'path'              => $path,
            'httpMethod'        => $httpMethod,
            'methodName'        => $methodName,
            'params'            => $params,
            'requestBody'       => $requestBody,
            'isAuth'            => $isAuth,
            'scopes'            => $scopes,
            'schemaName'        => $schemaName,
            'responseType'      => $responseType,
            'dtoClass'          => $dtoClass,
            'phpDocReturn'      => $phpDocReturn,
            'xPages'            => $xPages,
            'primitiveType'     => $primitiveType ?? ($primitivePhp ?? null),
            '_commonModelTypes' => $commonModelTypes,
            // ESI spec extensions — baked in at generation time
            'cacheAge'          => isset($op['x-cache-age']) ? (int) $op['x-cache-age'] : null,
            'rateLimit'         => $op['x-rate-limit'] ?? null,
            'requiredRoles'     => $op['x-required-roles'] ?? [],
            'cursor'            => ($op['x-pagination'] ?? null) === 'cursor',
        ];
    }
}

/** @var array<array<mixed>> $allOps — flat list of all operations for operation-class generation */
$allOps = array_merge(...array_values($tagOps));

// ---------------------------------------------------------------------------
// Collect DTOs
// ---------------------------------------------------------------------------

/** @var array<string, string> $dtoFiles className → PHP source */
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
    }
}

// ---------------------------------------------------------------------------
// Write files
// ---------------------------------------------------------------------------

$writtenDtos       = 0;
$writtenResources  = 0;
$writtenOperations = 0;

if (! $dryRun) {
    // --- DTOs ---
    if (! is_dir($responsesDir)) {
        mkdir($responsesDir, 0755, true);
    }
    foreach ($dtoFiles as $className => $source) {
        file_put_contents("{$responsesDir}/{$className}.php", $source);
        echo "  [dto] src/Responses/{$className}.php\n";
        $writtenDtos++;
    }

    // --- Resources ---
    if (! is_dir($resourcesDir)) {
        mkdir($resourcesDir, 0755, true);
    }
    foreach ($tagOps as $tag => $ops) {
        $source = generateResourceFile($tag, $ops);
        $class  = tagToResourceClass($tag);
        file_put_contents("{$resourcesDir}/{$class}.php", $source);
        echo "  [resource] src/Resources/{$class}.php\n";
        $writtenResources++;
    }

    // --- Operations ---
    if (! is_dir($operationsDir)) {
        mkdir($operationsDir, 0755, true);
    }
    foreach ($allOps as $op) {
        $source    = generateOperationClass($op);
        $className = ucfirst($op['methodName']);
        file_put_contents("{$operationsDir}/{$className}.php", $source);
        echo "  [operation] src/Operations/{$className}.php\n";
        $writtenOperations++;
    }
} else {
    foreach ($dtoFiles as $className => $_) {
        echo "  [dry-run][dto] src/Responses/{$className}.php\n";
        $writtenDtos++;
    }
    foreach ($tagOps as $tag => $_) {
        echo "  [dry-run][resource] src/Resources/" . tagToResourceClass($tag) . ".php\n";
        $writtenResources++;
    }
    foreach ($allOps as $op) {
        echo "  [dry-run][operation] src/Operations/" . ucfirst($op['methodName']) . ".php\n";
        $writtenOperations++;
    }
}

echo "\nDone.\n";
echo "  DTOs:       {$writtenDtos} files\n";
echo "  Resources:  {$writtenResources} files\n";
echo "  Operations: {$writtenOperations} files\n";
