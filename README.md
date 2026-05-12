# seatplus/esi-schema

**Typed ESI SDK for PHP.** Every EVE Online ESI endpoint has a strongly-typed resource method that returns a fully-typed DTO or paginated result — no string parsing, no `array` guesswork.

Generated from the ESI OpenAPI spec (`compatibility_date=2025-12-16`). Zero runtime dependencies.

---

## Installation

```bash
composer require seatplus/esi-schema
```

**Requirements:** PHP 8.3+

---

## Quick Start

Wire up a transport (provided by [seatplus/esi-client](https://github.com/seatplus/esi-client)) and you're done:

```php
use Seatplus\EsiSchema\Resources\AllianceResource;
use Seatplus\EsiSchema\Resources\AssetsResource;

// Inject any EsiTransportInterface implementation
$alliance  = new AllianceResource($transport);
$assets    = new AssetsResource($transport);

// Single-object endpoints — returns a typed DTO directly
$info = $alliance->getAlliancesAllianceId(99000006);
echo $info->name;    // 'Goonswarm Federation'  (typed string)
echo $info->ticker;  // 'CONDI'

// Paginated endpoints — returns EsiResult<T>
$page = $assets->getCharactersCharacterIdAssets(characterId: 12345, page: 1);
foreach ($page->data as $item) {
    echo $item->type_id;    // typed int
    echo $item->quantity;   // typed int
}
echo $page->pages;         // total pages from X-Pages header
echo $page->isCachedLoad;  // true when served from RFC 7234 cache
```

---

## Result-Level Metadata

Every result object carries ESI spec metadata baked in at generation time — no extra calls, no string operationIds:

```php
$result = $assets->getCharactersCharacterIdAssets(12345);

$result->rateLimitGroup();     // 'char-asset'
$result->rateLimitMaxTokens(); // 1800
$result->rateLimitWindow();    // '15m'
$result->cacheAge();           // 3600  (null for no-cache endpoints)
$result->requiredRoles();      // []    (['Director'] for corp endpoints)
$result->usesCursor();         // false (true for cursor-paginated endpoints)

// Corporation endpoint — different rate-limit group, requires Director role
$corpAssets = $assets->getCorporationsCorporationIdAssets(98000001);
$corpAssets->rateLimitGroup(); // 'corp-asset'
$corpAssets->requiredRoles();  // ['Director']
```

Object endpoints (single-DTO returns) carry the same accessors:

```php
$info = $alliance->getAlliancesAllianceId(99000006);
$info->cacheAge();       // 3600
$info->rateLimitGroup(); // null (alliance endpoints have no rate-limit group)
```

### Pre-call introspection

Use `AbstractResource::metaFor()` when you need metadata *before* making a call (e.g. to check required roles before dispatching a job):

```php
use Seatplus\EsiSchema\Resources\AssetsResource;

$meta = AssetsResource::metaFor('getCharactersCharacterIdAssets');
// ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-asset', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false]
```

---

## Implementing a Transport

All Resources depend only on `EsiTransportInterface`. Implement it to connect any HTTP client:

```php
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\Contracts\EsiRawResponse;

class MyTransport implements EsiTransportInterface
{
    public function invoke(
        string $method,
        string $path,
        array $pathValues = [],
        array $queryParams = [],
        array $requestBody = [],
    ): EsiRawResponse {
        // ... perform the HTTP request, handle caching, auth etc.
        return new EsiRawResponse(
            data: $responseBody,          // decoded JSON (mixed)
            isCachedLoad: $wasCached,     // bool
            pages: $xPagesHeader ?? 1,    // int
            rateLimitRemaining: $remaining,
            rateLimitUsed: $used,
            retryAfter: $retryAfter,      // null unless 429
        );
    }
}
```

The reference implementation is [seatplus/esi-client](https://github.com/seatplus/esi-client), which handles OAuth, RFC 7234 caching, error-limit tracking, and retry logic.

---

## Architecture

```
EsiTransportInterface          # Contract: any transport implements this
       │
       ▼
AbstractResource               # Base for all 33 generated Resource classes
 ├── OPERATION_META[]          # Per-operationId spec metadata (rate-limit, cache, roles, cursor)
 ├── metaFor(string): array    # Pre-call introspection
 └── getX() / postX() / ...   # Typed endpoint methods

       │ returns
       ▼
EsiResult<T>                   # Paginated/array endpoints
AbstractEsiDto subclass        # Single-object endpoints (e.g. AllianceDetail)
       │ both carry
       ▼
HasOperationMeta trait         # rateLimitGroup(), cacheAge(), requiredRoles(), ...
```

**Key contracts:**

| Class | Purpose |
|---|---|
| `EsiTransportInterface` | Contract for HTTP transport (invoke → EsiRawResponse) |
| `EsiRawResponse` | Raw transport response: data + HTTP metadata + rate-limit state |
| `EsiCursor` | Cursor pagination tokens (`$before`, `$after`) |
| `AbstractEsiDto` | Base DTO: `$isCachedLoad`, `$pages`, `$operationMeta` |
| `EsiResult<T>` | Typed wrapper for array endpoints |
| `HasOperationMeta` | Trait giving result/DTO objects 6 metadata accessors |

---

## Versioning

Each major version tracks a specific ESI compatibility date.

| Branch / Major | ESI Compatibility Date | Composer constraint |
|---|---|---|
| `1.x` | `2025-12-16` | `^1.0` |

When CCP publishes a new compatibility date with breaking schema changes, a new major version branch is created. Non-breaking spec changes (field additions, same date) are released as `1.x` patches.

---

## Regenerating

```bash
php bin/generate.php    # fetches latest spec, regenerates all DTOs + Resources
vendor/bin/pint         # auto-format generated output
```

The generator reads the live OAS3 spec from `https://esi.evetech.net/meta/openapi.yaml?compatibility_date=2025-12-16`.

---

## Testing

```bash
composer test               # lint + types + type-coverage + unit
composer test:unit          # Pest tests only
composer test:types         # PHPStan static analysis
composer test:type-coverage # 100% type coverage check
composer lint               # Pint auto-format (modifies files)
```
