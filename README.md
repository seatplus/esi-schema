# seatplus/esi-schema

**Typed ESI schema for PHP.** Every EVE Online ESI endpoint has its own generated class with typed pre-call metadata and a typed call method — no magic strings, no `array` guesswork.

Generated from the ESI OpenAPI spec (`compatibility_date=2025-12-16`). Zero runtime dependencies.

---

## Installation

```bash
composer require seatplus/esi-schema
```

**Requirements:** PHP 8.3+

---

## Quick Start

Each ESI endpoint has its own generated class under `src/Resources/{Tag}/`. Classes expose typed public constants, a `meta()` factory, and a static `execute()` method:

```php
use Seatplus\EsiSchema\Resources\Assets\GetCharactersCharacterIdAssets;
use Seatplus\EsiSchema\Resources\Market\GetMarketsPrices;

// 1. Pre-call introspection — no transport needed
$meta = GetCharactersCharacterIdAssets::meta();
$meta->requiredScope;        // 'esi-assets.read_assets.v1'
$meta->rateLimitGroup;       // 'char-asset'
$meta->rateLimitMaxTokens;   // 1800
$meta->rateLimitWindow;      // '15m'
$meta->cacheAge;             // 3600
$meta->requiredRoles;        // []  (['Director'] for corp endpoints)
$meta->usesCursor;           // false

// Or access constants directly — no allocation at all
GetCharactersCharacterIdAssets::REQUIRED_SCOPE;        // 'esi-assets.read_assets.v1'
GetCharactersCharacterIdAssets::RATE_LIMIT_GROUP;      // 'char-asset'
GetCharactersCharacterIdAssets::RATE_LIMIT_MAX_TOKENS; // 1800
GetCharactersCharacterIdAssets::CACHE_AGE;             // 3600

// Check a token before dispatching a job
if ($meta->requiredScope !== null && !in_array($meta->requiredScope, $token->scopes, true)) {
    throw new InsufficientScopeException($meta->requiredScope);
}

// 2. Typed call — inject any EsiTransportInterface
$result = GetCharactersCharacterIdAssets::execute($transport, characterId: 12345, page: 1);
foreach ($result->data as $item) {
    echo $item->type_id;    // typed int
    echo $item->quantity;   // typed int
}
echo $result->pages;        // total pages from X-Pages header
echo $result->isCachedLoad; // true when served from RFC 7234 cache

// Public endpoint — REQUIRED_SCOPE is null
$prices = GetMarketsPrices::execute($transport);
GetMarketsPrices::REQUIRED_SCOPE; // null
```

### Namespace table

Resource classes are grouped by ESI tag into 33 subfolders:

| Namespace | Example class |
|---|---|
| `Resources\Alliance` | `GetAlliancesAllianceId` |
| `Resources\Assets` | `GetCharactersCharacterIdAssets` |
| `Resources\Character` | `GetCharactersCharacterId` |
| `Resources\Corporation` | `GetCorporationsCorporationId` |
| `Resources\FactionWarfare` | `GetFwStats` |
| `Resources\Market` | `GetMarketsPrices` |
| `Resources\Universe` | `GetUniverseTypesTypeId` |
| `Resources\Wallet` | `GetCharactersCharacterIdWallet` |
| `Resources\Skills` | `GetCharactersCharacterIdSkills` |
| … (33 total) | |

Full class names follow the pattern `Seatplus\EsiSchema\Resources\{Tag}\{PascalCaseOperationId}`.

### eveapi integration pattern

The intended use in queue jobs:

```php
use Seatplus\EsiSchema\Resources\Assets\GetCharactersCharacterIdAssets;

class CharacterAssetJob extends EsiJob
{
    public function __construct(
        public readonly int $characterId,
        public readonly RefreshToken $token,
    ) {}

    // EsiJob base reads this to get scope, rate-limit group, etc.
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

## Implementing a Transport

All resource classes depend only on `EsiTransportInterface`. Implement it to connect any HTTP client:

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
EsiTransportInterface              # Contract: any transport implements this
       │
       └── Resources/{Tag}/        # 208 generated classes — one per ESI endpoint
            └── Assets/
                 └── GetCharactersCharacterIdAssets
                      ├── REQUIRED_SCOPE = 'esi-assets.read_assets.v1'  (typed const)
                      ├── RATE_LIMIT_GROUP = 'char-asset'                (typed const)
                      ├── CACHE_AGE = 3600                               (typed const)
                      ├── static meta(): OperationMeta   # pre-call typed metadata DTO
                      └── static execute($transport, ...): EsiResult     # typed call
```

**Key contracts:**

| Class / Interface | Purpose |
|---|---|
| `EsiOperationInterface` | Contract for resource classes: `static meta(): OperationMeta` |
| `EsiTransportInterface` | Contract for HTTP transport: `invoke() → EsiRawResponse` |
| `EsiRawResponse` | Raw transport response: data + HTTP metadata + rate-limit state |
| `EsiCursor` | Cursor pagination tokens (`$before`, `$after`) |
| `OperationMeta` | Typed pre-call DTO: 7 readonly properties (no methods) |
| `AbstractEsiDto` | Base DTO for single-object responses: `$isCachedLoad`, `$pages` |
| `EsiResult<T>` | Typed wrapper for array/paginated endpoints |

---

## Design Decisions

### 1. Static resource classes — one class per ESI endpoint

Each ESI endpoint is represented as a **pure static class** (`final class`) rather than an instance method on a tag-grouped resource. This means:

- **Zero allocation**: `GetCharactersCharacterIdAssets::meta()` is a direct static call — no `new`, no DI.
- **PHPStan traces the return type directly**: `::execute()` returns `EsiResult<GetCharactersCharacterIdAssetsItem>`, fully known at static analysis time.
- **The class name is the identifier**: `OPERATION = GetCharactersCharacterIdAssets::class` is a typed constant reference — no magic strings needed in jobs.

### 2. Typed public constants for metadata

Each generated class exposes 7 individually typed `public const` declarations:

```php
public const ?string REQUIRED_SCOPE        = 'esi-assets.read_assets.v1';
public const ?string RATE_LIMIT_GROUP      = 'char-asset';
public const ?int    RATE_LIMIT_MAX_TOKENS = 1800;
public const ?string RATE_LIMIT_WINDOW     = '15m';
public const ?int    CACHE_AGE             = 3600;
public const array   REQUIRED_ROLES        = [];
public const bool    USES_CURSOR           = false;
```

`meta()` simply wraps these into `new OperationMeta(...)`. The constants are also directly accessible without any method call or allocation.

### 3. `OperationMeta` as a pure typed DTO

`OperationMeta` is a `final readonly class` with **only typed constructor properties** — no methods. Access its values as `$meta->requiredScope`, `$meta->cacheAge`, etc.

Token validation logic is **not** in this library — `tokenSatisfies()` was removed. Scope checks belong in eveapi, where the token models live.

### 4. Tag-based subfolders

The 208 resource classes live in `src/Resources/{Tag}/` (33 subfolders), matching ESI's tag taxonomy:

- **Group imports** are idiomatic: `use Seatplus\EsiSchema\Resources\Assets\{GetCharactersCharacterIdAssets, GetCorporationsCorporationIdAssets}`.
- Tag names with spaces become PascalCase: `Faction Warfare` → `FactionWarfare`.

### 5. Zero runtime dependencies

`composer.json` has **no `require` entries** (only `require-dev` for `symfony/yaml` used by the generator). The published library is pure PHP 8.3.

### 6. `EsiTransportInterface` as the sole injection boundary

All network I/O is delegated to a single `invoke()` method. The library knows nothing about Guzzle, cURL, OAuth tokens, or HTTP caching. Tests mock this interface — no network required.

### 7. Versioning tied to ESI compatibility_date

| Library major | ESI compatibility_date | Composer |
|---|---|---|
| `1.x` | `2025-12-16` | `^1.0` |

When CCP introduces a new breaking date and generated types change incompatibly, a new major (`2.x`) is released.

---

## Versioning

| Branch / Major | ESI Compatibility Date | Composer constraint |
|---|---|---|
| `1.x` | `2025-12-16` | `^1.0` |

---

## Regenerating

```bash
php bin/generate.php    # fetches latest spec, regenerates all DTOs + Resources
vendor/bin/pint         # auto-format generated output (run after generate if needed)
```

The generator reads the live OAS3 spec from `https://esi.evetech.net/meta/openapi.yaml?compatibility_date=2025-12-16`.

It emits:
- `src/Responses/*.php` — ~218 typed DTO classes (one per ESI schema object)
- `src/Resources/{Tag}/*.php` — 208 resource classes grouped by ESI tag (33 subfolders)

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
