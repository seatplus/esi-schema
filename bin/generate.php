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
$strict   = (isset($args['strict']) || getenv('CI') !== false) && ! isset($args['no-strict']);

/**
 * Fetch a URL with retries, asserting a 2xx status.
 *
 * file_get_contents() returns false on failure, which under strict_types becomes
 * a TypeError somewhere downstream — a crash with a useless message. Fail here
 * instead, with the URL and status in the message.
 */
function fetchUrl(string $url, int $attempts = 3): string
{
    $context = stream_context_create([
        'http' => [
            'method'        => 'GET',
            'timeout'       => 60,
            'ignore_errors' => true,
            'header'        => "Accept: */*\r\nUser-Agent: seatplus-esi-schema-generator\r\n",
        ],
    ]);

    $lastError = 'unknown error';

    for ($attempt = 1; $attempt <= $attempts; $attempt++) {
        $body   = @file_get_contents($url, false, $context);
        $status = 0;
        foreach ($http_response_header ?? [] as $headerLine) {
            if (preg_match('#^HTTP/\S+\s+(\d{3})#', $headerLine, $m) === 1) {
                $status = (int) $m[1];
            }
        }

        if ($body !== false && $status >= 200 && $status < 300) {
            return $body;
        }

        $lastError = $body === false ? 'connection failed' : "HTTP {$status}";
        if ($attempt < $attempts) {
            $backoff = 2 ** ($attempt - 1);
            fwrite(STDERR, "  fetch failed ({$lastError}), retrying in {$backoff}s...\n");
            sleep($backoff);
        }
    }

    fwrite(STDERR, "FATAL: could not fetch {$url}: {$lastError}\n");
    exit(1);
}

/** Abort before writing anything if the spec looks degraded or is not the one we asked for. */
function assertSpecSane(array $spec, string $compatDate, int $byteLength, bool $strict): void
{
    $problems = [];

    if ($byteLength < 400_000) {
        $problems[] = "spec body is {$byteLength} bytes, expected >= 400000 (truncated response?)";
    }

    $pathCount   = count($spec['paths'] ?? []);
    $schemaCount = count($spec['components']['schemas'] ?? []);

    if ($pathCount < 180) {
        $problems[] = "only {$pathCount} paths, expected >= 180";
    }
    if ($schemaCount < 285) {
        $problems[] = "only {$schemaCount} schemas, expected >= 285";
    }

    $infoVersion = $spec['info']['version'] ?? null;
    if ($infoVersion !== null && $infoVersion !== $compatDate) {
        $problems[] = "info.version is '{$infoVersion}', expected '{$compatDate}'";
    }

    $enum = $spec['components']['parameters']['CompatibilityDate']['schema']['enum'] ?? null;
    if ($enum !== null && $enum !== [$compatDate]) {
        $problems[] = 'CompatibilityDate.enum is ' . json_encode($enum) . ", expected [\"{$compatDate}\"]";
    }

    if ($problems === []) {
        return;
    }

    $label = $strict ? 'FATAL' : 'WARNING';
    foreach ($problems as $problem) {
        fwrite(STDERR, "{$label}: {$problem}\n");
    }

    if ($strict) {
        fwrite(STDERR, "Refusing to generate from a suspect spec. Pass --no-strict to override.\n");
        exit(1);
    }
}

// ---------------------------------------------------------------------------
// Fetch compatibility dates and spec
// ---------------------------------------------------------------------------

$COMPAT_DATE_URL = 'https://esi.evetech.net/meta/compatibility-dates';
$SPEC_BASE_URL   = 'https://esi.evetech.net/meta/openapi.yaml';

if (isset($args['compatibility-date'])) {
    $compatDate = $args['compatibility-date'];
} elseif ($strict) {
    fwrite(STDERR, "FATAL: --compatibility-date is required in CI/strict mode.\n");
    fwrite(STDERR, "Never let an unattended run guess which spec to generate from.\n");
    exit(1);
} else {
    echo "Fetching compatibility dates...\n";
    $datesJson = fetchUrl($COMPAT_DATE_URL);
    $dates     = json_decode($datesJson, true)['compatibility_dates'] ?? [];
    if ($dates === []) {
        fwrite(STDERR, "FATAL: {$COMPAT_DATE_URL} returned no compatibility dates.\n");
        exit(1);
    }
    // ESI happens to return these newest-first, but that ordering is undocumented.
    $compatDate = max($dates);
    echo "Using compatibility_date: {$compatDate}\n";
}

if ($specFile) {
    echo "Loading spec from file: {$specFile}\n";
    $rawSpec = file_get_contents($specFile);
    if ($rawSpec === false) {
        fwrite(STDERR, "FATAL: could not read spec file {$specFile}\n");
        exit(1);
    }
} else {
    $specUrl = "{$SPEC_BASE_URL}?compatibility_date={$compatDate}";
    echo "Fetching spec from {$specUrl}...\n";
    $rawSpec = fetchUrl($specUrl);

    // ESI echoes the date it actually served. A proxy or cache handing back a
    // different spec is a failure no size check would notice.
    foreach ($http_response_header ?? [] as $headerLine) {
        if (stripos($headerLine, 'x-compatibility-date:') === 0) {
            $served = trim(substr($headerLine, strlen('x-compatibility-date:')));
            if ($served !== $compatDate) {
                fwrite(STDERR, "FATAL: asked for compatibility_date={$compatDate}, server served {$served}\n");
                exit(1);
            }
        }
    }
}

$specSha256 = hash('sha256', $rawSpec);

$spec    = Yaml::parse($rawSpec);
$schemas = $spec['components']['schemas'] ?? [];
$paths   = $spec['paths'] ?? [];

assertSpecSane($spec, $compatDate, strlen($rawSpec), $strict);

/** Shared parameter definitions, used to resolve $ref parameters. */
$specParameters = $spec['components']['parameters'] ?? [];

define('ESI_COMPATIBILITY_DATE', $compatDate);
define('ESI_SPEC_SHA256', $specSha256);

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
                \$dto->rateLimitRemaining = \$response->rateLimitRemaining;
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
                    rateLimitRemaining: \$response->rateLimitRemaining,
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
                    rateLimitRemaining: \$response->rateLimitRemaining,
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
                    rateLimitRemaining: \$response->rateLimitRemaining,
                );
        PHP,

        default => <<<PHP
                \$response = {$invoke};
                return new EsiResult(
                    data: null,
                    pages: \$response->pages,
                    isCachedLoad: \$response->isCachedLoad,
                    rateLimitRemaining: \$response->rateLimitRemaining,
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
                // Resolve any other $ref parameter rather than dropping it. Every
                // $ref parameter in the spec is currently skip-listed, so this
                // changes no output today — but the day CCP factors a real
                // parameter into components/parameters, dropping it here would
                // silently remove it from every execute() signature at once.
                $resolved = $specParameters[$paramName] ?? null;
                if ($resolved === null) {
                    fwrite(STDERR, "WARNING: unresolvable parameter \$ref '{$param['$ref']}' on {$op['operationId']}\n");

                    continue;
                }
                $params[] = $resolved;

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
// Build the complete write set in memory
//
// Everything is generated before a single byte is written, so a throw anywhere in
// generation leaves src/ untouched. That is also what makes pruning safe: the
// write set is authoritative, so anything under src/Responses or src/Resources
// that is absent from it is genuinely gone from the spec.
//
// Sorted, because the emitted set feeds .esi/surface.json and the manifest hash
// must not depend on YAML document order.
// ---------------------------------------------------------------------------

/** @var array<string, string> $writeSet absolute path → PHP source */
$writeSet = [];

ksort($dtoFiles);
foreach ($dtoFiles as $className => $source) {
    $writeSet["{$responsesDir}/{$className}.php"] = $source;
}

usort($allOps, static fn (array $a, array $b): int => [$a['tag'], $a['methodName']] <=> [$b['tag'], $b['methodName']]);
foreach ($allOps as $op) {
    $subNs     = str_replace(' ', '', $op['tag']);
    $className = ucfirst($op['methodName']);
    $writeSet["{$resourcesDir}/{$subNs}/{$className}.php"] = generateOperationClass($op);
}

ksort($tagOps);
foreach ($tagOps as $tagNs => $ops) {
    $writeSet["{$resourcesDir}/{$tagNs}Resource.php"] = generateTagClass($tagNs, $ops);
}

$writtenDtos      = count($dtoFiles);
$writtenResources = count($allOps);
$writtenTags      = count($tagOps);

// Floor check: a degraded spec that parsed but yielded almost nothing must not be
// allowed to delete the package. assertSpecSane() covers the input; this covers
// the output.
if (count($writeSet) < 400) {
    fwrite(STDERR, 'FATAL: write set is only ' . count($writeSet) . " files, expected >= 400.\n");
    fwrite(STDERR, "Refusing to prune src/ from a degraded generation.\n");
    exit(1);
}

// ---------------------------------------------------------------------------
// Existing generated files, for pruning
// ---------------------------------------------------------------------------

/** @return list<string> every generated .php file currently on disk */
function existingGeneratedFiles(string $responsesDir, string $resourcesDir): array
{
    $found = [];

    foreach ([$responsesDir, $resourcesDir] as $root) {
        if (! is_dir($root)) {
            continue;
        }
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
        );
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile() && $fileInfo->getExtension() === 'php') {
                $found[] = $fileInfo->getPathname();
            }
        }
    }

    sort($found);

    return $found;
}

$existing = existingGeneratedFiles($responsesDir, $resourcesDir);
$stale    = array_values(array_diff($existing, array_keys($writeSet)));

// ---------------------------------------------------------------------------
// Write, then prune
// ---------------------------------------------------------------------------

if ($dryRun) {
    foreach (array_keys($writeSet) as $path) {
        echo '  [dry-run][write] ' . relativeToRoot($path) . "\n";
    }
    foreach ($stale as $path) {
        echo '  [dry-run][prune] ' . relativeToRoot($path) . "\n";
    }
} else {
    foreach ($writeSet as $path => $source) {
        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($path, $source);
        echo '  [write] ' . relativeToRoot($path) . "\n";
    }

    foreach ($stale as $path) {
        unlink($path);
        echo '  [prune] ' . relativeToRoot($path) . "\n";
    }

    // Remove tag directories the spec no longer has any operations for.
    foreach (glob("{$resourcesDir}/*", GLOB_ONLYDIR) ?: [] as $dir) {
        if ((glob("{$dir}/*.php") ?: []) === []) {
            rmdir($dir);
            echo '  [prune] ' . relativeToRoot($dir) . "/\n";
        }
    }
}

function relativeToRoot(string $path): string
{
    // Paths are built from __DIR__ . '/../src/...', so collapse the '..' segment
    // before comparing — realpath() is unusable here for files not yet written.
    $normalised = preg_replace('#/[^/]+/\.\./#', '/', $path) ?? $path;
    $root       = dirname(__DIR__) . '/';

    return str_starts_with($normalised, $root) ? substr($normalised, strlen($root)) : $normalised;
}

echo "\nDone.\n";
echo "  DTOs:        {$writtenDtos} files\n";
echo "  Resources:   {$writtenResources} files\n";
echo "  Tag classes: {$writtenTags} files\n";
echo '  Pruned:      ' . count($stale) . " files\n";
