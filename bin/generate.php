#!/usr/bin/env php
<?php

/**
 * ESI Schema Generator — OpenAPI 3.1.0 edition
 *
 * Fetches the ESI OpenAPI YAML spec and generates:
 *   - src/Responses/{SchemaName}.php             (item DTOs, one per object schema)
 *   - src/Resources/{Tag}/{OperationId}.php       (one class per ESI route, grouped by tag)
 *   - src/Resources/{Tag}Resource.php             (fluent tag-group wrappers, one per tag)
 *
 * All DTOs extend AbstractEsiDto which carries $isCachedLoad and $pages.
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
        $constructorLines[] = "        public readonly {$phpType} \${$propName},";

        if ($phpType === 'array') {
            $items = $prop['items'] ?? [];
            if (isset($items['$ref'])) {
                $itemClass = resolveRef($items['$ref'], $commonModelTypes);
                if (! in_array($itemClass, ['int', 'float', 'bool', 'string'], true)) {
                    $fromLines[] = "            {$propName}: array_map(fn (object \$i) => {$itemClass}::from(\$i), (array) (\$data->{$propName} ?? [])),";
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
    array_unshift($useStatements, 'use Seatplus\\EsiSchema\\AbstractEsiDto;');
    $useBlock         = implode("\n", array_unique($useStatements));

    $fullName   = $className . $suffix;
    $compatDate = ESI_COMPATIBILITY_DATE;

    return <<<PHP
    <?php

    namespace Seatplus\\EsiSchema\\Responses;

    {$useBlock}

    /**
     * Generated from ESI OpenAPI spec (compatibility date: {$compatDate}).
     * Do not edit manually — run bin/generate.php instead.
     */
    final class {$fullName} extends AbstractEsiDto
    {
        public function __construct(
    {$constructorBlock}
        ) {
        }

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
// ---------------------------------------------------------------------------
// Generator: per-route operation class
// ---------------------------------------------------------------------------

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
                return \$dto;
        PHP,

        'array_item', 'array_ref' => <<<PHP
                \$response = {$invoke};
                return new EsiResult(
                    data: array_map(
                        fn (object \$item) => {$dto}::from(\$item),
                        (array) \$response->data,
                    ),
                    pages: \$response->pages,
                    isCachedLoad: \$response->isCachedLoad,
                );
        PHP,

        'array_primitive' => <<<PHP
                \$response = {$invoke};
                /** @var array<{$primT}> \$data */
                \$data = array_map(fn (mixed \$i) => ({$primT}) \$i, (array) \$response->data);
                return new EsiResult(
                    data: \$data,
                    pages: \$response->pages,
                    isCachedLoad: \$response->isCachedLoad,
                );
        PHP,

        'primitive' => <<<PHP
                \$response = {$invoke};
                /** @var {$primT} \$scalar */
                \$scalar = ({$primT}) \$response->data;
                return new EsiResult(
                    data: \$scalar,
                    pages: \$response->pages,
                    isCachedLoad: \$response->isCachedLoad,
                );
        PHP,

        default => <<<PHP
                \$response = {$invoke};
                return new EsiResult(
                    data: null,
                    pages: \$response->pages,
                    isCachedLoad: \$response->isCachedLoad,
                );
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

// ---------------------------------------------------------------------------
// Helper: build positional call arguments for delegation to static execute()
// ---------------------------------------------------------------------------

function buildCallArgs(array $op): string
{
    $args   = [];
    $params = $op['params'];

    usort($params, fn ($a, $b) => ($b['required'] ?? false) <=> ($a['required'] ?? false));

    if ($op['requestBody']) {
        $args[] = '$requestBody';
    }

    foreach ($params as $param) {
        $name   = lcfirst(str_replace('_', '', ucwords($param['name'], '_')));
        $args[] = "\${$name}";
    }

    return implode(', ', $args);
}

// ---------------------------------------------------------------------------
// Generator: per-route operation class
// ---------------------------------------------------------------------------

function generateOperationClass(array $op): string
{
    $compatDate  = ESI_COMPATIBILITY_DATE;
    $className   = ucfirst($op['methodName']);  // PascalCase operationId
    $subNs       = str_replace(' ', '', $op['tag']); // 'Faction Warfare' → 'FactionWarfare'
    $sig         = buildMethodSig($op);
    $execSig     = $sig !== '' ? "EsiTransportInterface \$transport, {$sig}" : "EsiTransportInterface \$transport";
    $body        = buildReturn($op);
    $returnHint  = $op['responseType'] === 'object' ? ($op['dtoClass'] ?? 'mixed') : 'EsiResult';
    $doc         = "     * @return {$op['phpDocReturn']}";
    $auth        = $op['isAuth'] ? "\n     * @scope " . implode(', ', $op['scopes']) : '';
    $paged       = $op['xPages'] ? "\n     * @paginated Use \$page param to iterate pages." : '';

    // Individual typed constants
    $cacheAge        = $op['cacheAge'] !== null ? (string) $op['cacheAge'] : 'null';
    $requiredRoles   = empty($op['requiredRoles']) ? '[]' : "['" . implode("', '", $op['requiredRoles']) . "']";
    $cursor          = $op['cursor'] ? 'true' : 'false';
    $requiredScope   = empty($op['scopes']) ? 'null' : "'" . $op['scopes'][0] . "'";
    $rateLimitGroup  = $op['rateLimit'] !== null ? "'{$op['rateLimit']['group']}'" : 'null';
    $rateLimitTokens = $op['rateLimit'] !== null ? (string) (int) $op['rateLimit']['max-tokens'] : 'null';
    $rateLimitWindow = $op['rateLimit'] !== null ? "'{$op['rateLimit']['window-size']}'" : 'null';

    $useStatements   = ['use Seatplus\\EsiSchema\\Contracts\\EsiOperationInterface;'];
    $useStatements[] = 'use Seatplus\\EsiSchema\\Contracts\\EsiTransportInterface;';
    if ($returnHint === 'EsiResult') {
        $useStatements[] = 'use Seatplus\\EsiSchema\\EsiResult;';
    }
    $useStatements[] = 'use Seatplus\\EsiSchema\\OperationMeta;';

    if ($op['dtoClass'] && ! in_array($op['dtoClass'], ['int', 'float', 'bool', 'string'], true)) {
        $useStatements[] = "use Seatplus\\EsiSchema\\Responses\\{$op['dtoClass']};";
    }

    // Replace $this->transport with $transport (operation classes are static)
    $staticBody = str_replace('$this->transport->invoke', '$transport->invoke', $body);

    // Prepend assertScope call so every execute() enforces its own scope requirement.
    // This is the first statement so it throws before any HTTP call is made.
    $staticBody = "        \$transport->assertScope(self::REQUIRED_SCOPE);\n" . $staticBody;

    $useBlock = implode("\n", array_unique($useStatements));

    return <<<PHP
    <?php

    declare(strict_types=1);

    namespace Seatplus\\EsiSchema\\Resources\\{$subNs};

    {$useBlock}

    /**
     * ESI operation: {$op['methodName']}
     *
     * Generated from ESI OpenAPI spec (compatibility date: {$compatDate}).
     * Do not edit manually — run bin/generate.php instead.
     */
    final class {$className} implements EsiOperationInterface
    {
        /** Required OAuth2 scope. Null for public endpoints. */
        public const ?string REQUIRED_SCOPE = {$requiredScope};

        /** Rate-limit group name (e.g. 'char-asset'). Null when not rate-limited. */
        public const ?string RATE_LIMIT_GROUP = {$rateLimitGroup};

        /** Maximum token bucket size for this rate-limit group. */
        public const ?int RATE_LIMIT_MAX_TOKENS = {$rateLimitTokens};

        /** Rate-limit window duration (e.g. '15m'). */
        public const ?string RATE_LIMIT_WINDOW = {$rateLimitWindow};

        /** Cache TTL in seconds. Null for non-cached endpoints. */
        public const ?int CACHE_AGE = {$cacheAge};

        /**
         * EVE corporation roles required (e.g. ['Director']).
         *
         * @var list<string>
         */
        public const array REQUIRED_ROLES = {$requiredRoles};

        /** True for cursor-paginated endpoints. */
        public const bool USES_CURSOR = {$cursor};

        public static function meta(): OperationMeta
        {
            return new OperationMeta(
                requiredScope: self::REQUIRED_SCOPE,
                rateLimitGroup: self::RATE_LIMIT_GROUP,
                rateLimitMaxTokens: self::RATE_LIMIT_MAX_TOKENS,
                rateLimitWindow: self::RATE_LIMIT_WINDOW,
                cacheAge: self::CACHE_AGE,
                requiredRoles: self::REQUIRED_ROLES,
                usesCursor: self::USES_CURSOR,
            );
        }

        /**
    {$doc}{$auth}{$paged}
         */
        public static function execute({$execSig}): {$returnHint}
        {
    {$staticBody}
        }
    }

    PHP;
}

// ---------------------------------------------------------------------------
// Generator: flat tag-group resource class (fluent API entry point)
// ---------------------------------------------------------------------------

/**
 * @param string              $tagNs   Tag namespace, spaces already removed ('FactionWarfare')
 * @param array<array<mixed>> $ops     All operations belonging to this tag
 */
function generateTagClass(string $tagNs, array $ops): string
{
    $compatDate = ESI_COMPATIBILITY_DATE;
    $className  = "{$tagNs}Resource";

    $methods       = [];
    $usesEsiResult = false;
    $useStatements = ['use Seatplus\\EsiSchema\\Contracts\\EsiTransportInterface;'];

    foreach ($ops as $op) {
        $opClass    = ucfirst($op['methodName']);
        $methodName = $op['methodName'];
        $sig        = buildMethodSig($op);
        $callArgs   = buildCallArgs($op);
        $returnHint = $op['responseType'] === 'object' ? ($op['dtoClass'] ?? 'mixed') : 'EsiResult';
        // For EsiResult returns drop the generic type — item DTOs aren't imported in tag classes.
        // The delegated per-route static already carries the full typed return annotation.
        $doc        = $returnHint === 'EsiResult' ? '@return EsiResult' : "@return {$op['phpDocReturn']}";
        $auth       = $op['isAuth'] ? "\n * @scope " . implode(', ', $op['scopes']) : '';
        $paged      = $op['xPages'] ? "\n * @paginated Use \$page param to iterate pages." : '';

        $useStatements[] = "use Seatplus\\EsiSchema\\Resources\\{$tagNs}\\{$opClass};";

        if ($returnHint !== 'EsiResult' && $op['dtoClass'] && ! in_array($op['dtoClass'], ['int', 'float', 'bool', 'string'], true)) {
            $useStatements[] = "use Seatplus\\EsiSchema\\Responses\\{$op['dtoClass']};";
        }

        if ($returnHint === 'EsiResult') {
            $usesEsiResult = true;
        }

        $callExpr = $callArgs !== ''
            ? "{$opClass}::execute(\$this->transport, {$callArgs})"
            : "{$opClass}::execute(\$this->transport)";

        $methods[] = <<<PHP
        /**
         * {$doc}{$auth}{$paged}
         */
        public function {$methodName}({$sig}): {$returnHint}
        {
            return {$callExpr};
        }
        PHP;
    }

    if ($usesEsiResult) {
        array_splice($useStatements, 1, 0, ['use Seatplus\\EsiSchema\\EsiResult;']);
    }

    $useBlock   = implode("\n", array_unique($useStatements));
    $methodsStr = implode("\n\n", $methods);

    return <<<PHP
    <?php

    declare(strict_types=1);

    namespace Seatplus\\EsiSchema\\Resources;

    {$useBlock}

    /**
     * ESI {$tagNs} resource — fluent wrapper around per-route static classes.
     *
     * Generated from ESI OpenAPI spec (compatibility date: {$compatDate}).
     * Do not edit manually — run bin/generate.php instead.
     */
    final class {$className}
    {
        public function __construct(private readonly EsiTransportInterface \$transport) {}

    {$methodsStr}
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
            'tag'               => $tag,
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
$writtenTags       = 0;

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
    foreach ($allOps as $op) {
        $subNs     = str_replace(' ', '', $op['tag']);
        $subDir    = "{$resourcesDir}/{$subNs}";
        if (! is_dir($subDir)) {
            mkdir($subDir, 0755, true);
        }
        $source    = generateOperationClass($op);
        $className = ucfirst($op['methodName']);
        file_put_contents("{$subDir}/{$className}.php", $source);
        echo "  [resource] src/Resources/{$subNs}/{$className}.php\n";
        $writtenResources++;
    }

    // --- Tag classes ---
    foreach ($tagOps as $tagNs => $ops) {
        $source = generateTagClass($tagNs, $ops);
        file_put_contents("{$resourcesDir}/{$tagNs}Resource.php", $source);
        echo "  [tag] src/Resources/{$tagNs}Resource.php\n";
        $writtenTags++;
    }
} else {
    foreach ($dtoFiles as $className => $_) {
        echo "  [dry-run][dto] src/Responses/{$className}.php\n";
        $writtenDtos++;
    }
    foreach ($allOps as $op) {
        $subNs = str_replace(' ', '', $op['tag']);
        echo "  [dry-run][resource] src/Resources/{$subNs}/" . ucfirst($op['methodName']) . ".php\n";
        $writtenResources++;
    }
    foreach ($tagOps as $tagNs => $_) {
        echo "  [dry-run][tag] src/Resources/{$tagNs}Resource.php\n";
        $writtenTags++;
    }
}

echo "\nDone.\n";
echo "  DTOs:       {$writtenDtos} files\n";
echo "  Resources:  {$writtenResources} files\n";
echo "  Tag classes:{$writtenTags} files\n";
