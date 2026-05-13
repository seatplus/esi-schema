# seatplus/esi-schema

**Typed ESI schema for PHP.** Every EVE Online ESI endpoint has its own generated class with typed pre-call metadata (`meta()`) and a typed call method (`execute()`) — no magic strings, no `array` guesswork.

Generated from the ESI OpenAPI spec (`compatibility_date=2025-12-16`). Zero runtime dependencies.

---

## Installation

```bash
composer require seatplus/esi-schema
```

**Requirements:** PHP 8.3+

---

## Quick Start — Operation Classes

Each ESI endpoint has its own generated class under `src/Operations/`. Classes implement `EsiOperationInterface` and expose two static methods:

```php
use Seatplus\EsiSchema\Operations\GetCharactersCharacterIdAssets;
use Seatplus\EsiSchema\Operations\GetMarketsPrices;

// 1. Pre-call introspection — no transport needed
$meta = GetCharactersCharacterIdAssets::meta();
$meta->requiredScope();       // 'esi-assets.read_assets.v1'
$meta->rateLimitGroup();      // 'char-asset'
$meta->rateLimitMaxTokens();  // 1800
$meta->rateLimitWindow();     // '15m'
$meta->cacheAge();            // 3600
$meta->requiredRoles();       // []  (['Director'] for corp endpoints)
$meta->usesCursor();          // false

// Check a token before dispatching a job
if (!$meta->tokenSatisfies($token->scopes)) {
    throw new InsufficientScopeException($meta->requiredScope());
}

// 2. Typed call — inject any EsiTransportInterface
$result = GetCharactersCharacterIdAssets::execute($transport, characterId: 12345, page: 1);
foreach ($result->data as $item) {
    echo $item->type_id;    // typed int
    echo $item->quantity;   // typed int
}
echo $result->pages;         // total pages from X-Pages header
echo $result->isCachedLoad;  // true when served from RFC 7234 cache

// Result carries the same metadata as meta()
$result->rateLimitGroup();   // 'char-asset'
$result->requiredScope();    // 'esi-assets.read_assets.v1'

// Public endpoint — requiredScope() is null, tokenSatisfies() always true
$prices = GetMarketsPrices::execute($transport);
GetMarketsPrices::meta()->requiredScope(); // null
```

### eveapi pattern

The intended use in queue jobs:

```php
class CharacterAssetJob extends EsiJob
{
    public function __construct(
        public readonly int $characterId,
        public readonly RefreshToken $token,
    ) {}

    // EsiJob base reads this automatically: scope check, rate-limit group, etc.
    protected const string OPERATION = GetCharactersCharacterIdAssets::class;

    protected function executeJob(EsiTransportInterface $transport): void
    {
        $result = GetCharactersCharacterIdAssets::execute(
            $transport, $this->characterId
        );
        if ($result->isCachedLoad) return;
        Asset::upsert(/* ... */);
    }
}
```

---

## Tag-Based Resources (legacy API)

The 33 tag-based Resource classes (`AssetsResource`, `AllianceResource`, …) are retained for backwards compatibility. They group endpoint methods by ESI tag:

```php
use Seatplus\EsiSchema\Resources\AssetsResource;

$assets = new AssetsResource($transport);

// Instance method — paginated call
$page = $assets->getCharactersCharacterIdAssets(characterId: 12345, page: 1);
foreach ($page->data as $item) { /* ... */ }

// Static companion — pre-call metadata, no transport needed
$meta = AssetsResource::getCharactersCharacterIdAssetsMeta();
// equivalent to GetCharactersCharacterIdAssets::meta()

// Dynamic lookup by operationId (for logging, middleware)
$meta = AssetsResource::metaFor('getCharactersCharacterIdAssets');
```

Every result/DTO carries the same metadata accessors as the `OperationMeta` DTO:

```php
$result = $assets->getCharactersCharacterIdAssets(12345);
$result->rateLimitGroup();     // 'char-asset'
$result->rateLimitMaxTokens(); // 1800
$result->cacheAge();           // 3600
$result->requiredRoles();      // []
$result->usesCursor();         // false
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
       ├── Operations/         # 208 generated classes — one per ESI endpoint
       │    └── GetCharactersCharacterIdAssets
       │         ├── static meta(): OperationMeta   # pre-call typed metadata
       │         └── static execute($transport, ...$args): EsiResult
       │
       └── Resources/          # 33 generated tag-based resource classes (legacy)
            └── AssetsResource($transport)
                 ├── getCharactersCharacterIdAssets(...): EsiResult
                 ├── static getCharactersCharacterIdAssetsMeta(): OperationMeta
                 └── static metaFor(string $operationId): OperationMeta

       both return
       ▼
EsiResult<T>                   # Paginated/array endpoints
AbstractEsiDto subclass        # Single-object endpoints (e.g. AllianceDetail)
OperationMeta                  # Pre-call DTO (from meta() or metaFor())
       │ all three carry
       ▼
HasOperationMeta trait         # rateLimitGroup(), cacheAge(), requiredScope(), ...
```

**Key contracts:**

| Class / Interface | Purpose |
|---|---|
| `EsiOperationInterface` | Contract for operation classes: `static meta(): OperationMeta` |
| `EsiTransportInterface` | Contract for HTTP transport: `invoke() → EsiRawResponse` |
| `EsiRawResponse` | Raw transport response: data + HTTP metadata + rate-limit state |
| `EsiCursor` | Cursor pagination tokens (`$before`, `$after`) |
| `OperationMeta` | Typed pre-call DTO: all spec metadata + `tokenSatisfies()` |
| `AbstractEsiDto` | Base DTO: `$isCachedLoad`, `$pages`, `$operationMeta` |
| `EsiResult<T>` | Typed wrapper for array/paginated endpoints |
| `HasOperationMeta` | Trait: 7 metadata accessors on result objects and `OperationMeta` |

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
php bin/generate.php    # fetches latest spec, regenerates all DTOs + Resources + Operations
vendor/bin/pint         # auto-format generated output
```

The generator reads the live OAS3 spec from `https://esi.evetech.net/meta/openapi.yaml?compatibility_date=2025-12-16`.

It emits:
- `src/Responses/*.php` — ~218 typed DTO classes (one per ESI schema object)
- `src/Resources/*.php` — 33 tag-based resource classes
- `src/Operations/*.php` — 208 operation classes (one per ESI endpoint)

---

## Testing

```bash
composer test               # lint + types + type-coverage + unit
composer test:unit          # Pest tests only
composer test:types         # PHPStan static analysis
composer test:type-coverage # 100% type coverage check
composer lint               # Pint auto-format (modifies files)
```
