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

Each ESI endpoint has its own generated class under `src/Operations/{Tag}/`. Classes implement `EsiOperationInterface` and expose two static methods:

```php
use Seatplus\EsiSchema\Operations\Assets\GetCharactersCharacterIdAssets;
use Seatplus\EsiSchema\Operations\Market\GetMarketsPrices;

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

### Operation class namespaces

Operations are grouped by ESI tag into 33 subfolders:

| Namespace | Example class |
|---|---|
| `Operations\Alliance` | `GetAlliancesAllianceId` |
| `Operations\Assets` | `GetCharactersCharacterIdAssets` |
| `Operations\Character` | `GetCharactersCharacterId` |
| `Operations\Corporation` | `GetCorporationsCorporationId` |
| `Operations\FactionWarfare` | `GetFwStats` |
| `Operations\Market` | `GetMarketsPrices` |
| `Operations\Universe` | `GetUniverseTypesTypeId` |
| `Operations\Wallet` | `GetCharactersCharacterIdWallet` |
| `Operations\Skills` | `GetCharactersCharacterIdSkills` |
| … (33 total) | |

Full class names follow the pattern `Seatplus\EsiSchema\Operations\{Tag}\{PascalCaseOperationId}`.

### eveapi integration pattern

The intended use in queue jobs:

```php
use Seatplus\EsiSchema\Operations\Assets\GetCharactersCharacterIdAssets;

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

All Resources and Operations depend only on `EsiTransportInterface`. Implement it to connect any HTTP client:

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
       │    └── Assets/
       │         └── GetCharactersCharacterIdAssets
       │              ├── static meta(): OperationMeta   # pre-call typed metadata
       │              └── static execute($transport, ...$args): EsiResult
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

## Design Decisions

### 1. Static operation classes

Each ESI endpoint is represented as a **pure static class** (`final class`) rather than an instantiated service or a method on a resource. This means:

- **Zero allocation**: `GetCharactersCharacterIdAssets::meta()` is a direct static call — no `new`, no DI.
- **PHPStan traces the return type directly**: `::execute()` returns `EsiResult<GetCharactersCharacterIdAssetsItem>`, fully known at static analysis time.
- **The class name is the identifier**: `OPERATION = GetCharactersCharacterIdAssets::class` is a constant reference — no magic strings needed in jobs.

### 2. OPERATION_META baked in at generation time

The metadata array (`requiredScope`, `rateLimitGroup`, `cacheAge`, …) is **embedded as a PHP constant** inside each generated class:

```php
private const array OPERATION_META = [
    'requiredScope' => 'esi-assets.read_assets.v1',
    'rateLimit'     => ['group' => 'char-asset', 'max-tokens' => 1800, 'window-size' => '15m'],
    'cacheAge'      => 3600,
    'requiredRoles' => [],
];
```

There is no runtime spec fetch, no file read, no I/O. The trade-off: when CCP changes the spec, you must **regenerate and release a new version**. This is intentional — spec drift is a deploy-time concern, not a runtime concern.

### 3. Tag-based subfolders for Operations

The 208 operation classes live in `src/Operations/{Tag}/` (33 subfolders), matching the ESI API tag taxonomy. This means:

- **Group imports** are idiomatic: `use Seatplus\EsiSchema\Operations\Assets\{GetCharactersCharacterIdAssets, GetCorporationsCorporationIdAssets}`.
- The folder structure mirrors the `Resources/` layer, making it easy to locate related classes.
- Tag names with spaces become PascalCase: `Faction Warfare` → `FactionWarfare`.

### 4. `HasOperationMeta` as a trait (not a base class)

The 7 metadata accessors (`rateLimitGroup()`, `cacheAge()`, `requiredScope()`, …) are implemented once in `Concerns\HasOperationMeta` and mixed into three unrelated types:

- `EsiResult<T>` — a `readonly class` (cannot extend an abstract class)
- `AbstractEsiDto` — an abstract class for single-object DTOs
- `OperationMeta` — the pre-call DTO itself

A shared base class would require all three to extend the same root, which is impossible across `readonly` and `abstract` classes in PHP. The trait avoids this without duplicating logic.

### 5. Zero runtime dependencies

`composer.json` has **no `require` entries** (only `require-dev` for `symfony/yaml` used by the generator). The published library is pure PHP 8.3. Any consumer project controls their own HTTP, caching, and serialization stack. This library's only job is to describe ESI's type system.

### 6. `EsiTransportInterface` as the sole injection boundary

All network I/O is delegated to the single `EsiTransportInterface::invoke()` method. The library knows nothing about Guzzle, cURL, OAuth tokens, or HTTP caching. This separation means:

- Tests mock `EsiTransportInterface` — no network required.
- The reference transport ([seatplus/esi-client](https://github.com/seatplus/esi-client)) can be swapped for any other HTTP client by any consumer.
- Future changes to ESI's auth model only affect the transport, not this library.

### 7. Versioning tied to ESI compatibility_date

ESI uses [`compatibility_date`](https://github.com/esi/esi-docs/blob/main/docs/services/esi) to gate breaking spec changes behind an opt-in date. This library's major version tracks the spec date in use:

| Library major | ESI compatibility_date | Composer |
|---|---|---|
| `1.x` | `2025-12-16` | `^1.0` |

When CCP introduces a new breaking date and the generated types change in a backwards-incompatible way, a new `2.x` major is released. Minor versions within a major are used for generator improvements and non-breaking spec additions.

### 8. Resources retained for backwards compatibility

The `Resources/` layer (33 tag-based classes with instance methods) was the original API. It remains fully functional and is not deprecated — it is simply a higher-level wrapper over the same `OPERATION_META` data. The Operation classes are the **canonical new API**; Resources are preferred when you want to call several endpoints on the same tag without repeating the transport argument.

---

## Versioning

| Branch / Major | ESI Compatibility Date | Composer constraint |
|---|---|---|
| `1.x` | `2025-12-16` | `^1.0` |

When CCP publishes a new compatibility date with breaking schema changes, a new major version branch is created. Non-breaking spec changes (field additions, same date) are released as `1.x` patches.

---

## Regenerating

```bash
php bin/generate.php    # fetches latest spec, regenerates all DTOs + Resources + Operations
vendor/bin/pint         # auto-format generated output (run after generate if needed)
```

The generator reads the live OAS3 spec from `https://esi.evetech.net/meta/openapi.yaml?compatibility_date=2025-12-16`.

It emits:
- `src/Responses/*.php` — ~218 typed DTO classes (one per ESI schema object)
- `src/Resources/*.php` — 33 tag-based resource classes
- `src/Operations/{Tag}/*.php` — 208 operation classes grouped by ESI tag

**Do not manually edit generated files.** Changes are overwritten on next regeneration. To change generated output, edit `bin/generate.php`.

---

## Testing

```bash
composer test               # lint + types + type-coverage + unit
composer test:unit          # Pest tests only
composer test:types         # PHPStan static analysis
composer test:type-coverage # 100% type coverage check
composer lint               # Pint auto-format (modifies files)
```

---

## Contributing

See [ARCHITECTURE.md](ARCHITECTURE.md) for detailed design rationale.
