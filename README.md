# seatplus/esi-schema

**Typed ESI schema for PHP.** Every EVE Online ESI endpoint has its own generated class with typed pre-call metadata and a typed call method — no magic strings, no `array` guesswork.

Generated from the ESI OpenAPI spec (`compatibility_date=2026-05-19`). Zero runtime dependencies.

---

## Installation

```bash
composer require seatplus/esi-schema
```

**Requirements:** PHP 8.3+

---

## Quick Start

Two call styles are available. Choose based on context.

### Option A — Direct static call (recommended for jobs and services)

Each ESI endpoint has its own generated class under `src/Resources/{Tag}/`:

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

### Option B — Fluent API (convenient for interactive use and esi-client)

A generated `{Tag}Resource` wrapper class exists for every tag. Inject the transport once and call methods fluently:

```php
use Seatplus\EsiSchema\Resources\AssetsResource;
use Seatplus\EsiSchema\Resources\CharacterResource;

// Construct with any EsiTransportInterface
$assets     = new AssetsResource($transport);
$characters = new CharacterResource($transport);

// Same parameters, same return types as the static API
$result = $assets->getCharactersCharacterIdAssets(characterId: 12345, page: 1);
$dto    = $characters->getCharactersCharacterId(characterId: 12345);

// With esi-client (EsiClient implements EsiTransportInterface):
$result = $esiClient->withToken($accessToken)->assets()->getCharactersCharacterIdAssets(12345, page: 1);
```

Each `{Tag}Resource` method is a thin wrapper — it simply calls `{OperationClass}::execute($this->transport, ...)`. Pre-call metadata and typed constants remain on the per-route class.

### Namespace table

Resource classes are grouped by ESI tag into 33 subfolders, each with a corresponding tag-group wrapper:

| Subfolder | Example class | Tag wrapper |
|---|---|---|
| `Resources\Alliance` | `GetAlliancesAllianceId` | `AllianceResource` |
| `Resources\Assets` | `GetCharactersCharacterIdAssets` | `AssetsResource` |
| `Resources\Character` | `GetCharactersCharacterId` | `CharacterResource` |
| `Resources\Corporation` | `GetCorporationsCorporationId` | `CorporationResource` |
| `Resources\FactionWarfare` | `GetFwStats` | `FactionWarfareResource` |
| `Resources\Market` | `GetMarketsPrices` | `MarketResource` |
| `Resources\Universe` | `GetUniverseTypesTypeId` | `UniverseResource` |
| `Resources\Wallet` | `GetCharactersCharacterIdWallet` | `WalletResource` |
| `Resources\Skills` | `GetCharactersCharacterIdSkills` | `SkillsResource` |
| … (33 total) | | |

Per-route classes: `Seatplus\EsiSchema\Resources\{Tag}\{PascalCaseOperationId}`  
Tag wrappers: `Seatplus\EsiSchema\Resources\{Tag}Resource` (e.g. `Seatplus\EsiSchema\Resources\AssetsResource`)

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
       ├── Resources/{Tag}Resource  # 33 generated tag wrappers — fluent API entry points
       │    └── AssetsResource
       │         ├── __construct(EsiTransportInterface $transport)
       │         └── getCharactersCharacterIdAssets($id, $page)  # delegates to ↓
       │
       └── Resources/{Tag}/         # 208 generated classes — one per ESI endpoint
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
| `{Tag}Resource` | Fluent wrapper — stores transport, methods delegate to per-route statics |

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

| Branch / Major | ESI compatibility_date | Composer | Notes |
|---|---|---|---|
| `main` | `2026-05-19` | `dev-main` | Always the latest — updated automatically |
| `2.x` | `2026-05-19` | `^2.0` | Stable freeze |
| `1.x` | `2025-12-16` | `^1.0` | Stable freeze |

When CCP introduces a new breaking compatibility date, the action regenerates on a new `N.x` branch, opens a `[REVIEW ONLY]` PR to `main`, and after merging both `main` and `N.x` point to the same commit.

---

## Versioning

| Branch / Major | ESI Compatibility Date | Composer constraint |
|---|---|---|
| `main` | `2026-05-19` | `dev-main` |
| `2.x` | `2026-05-19` | `^2.0` |
| `1.x` | `2025-12-16` | `^1.0` |

---

## Regenerating

```bash
php bin/generate.php    # fetches latest spec, regenerates all DTOs + Resources
vendor/bin/pint         # auto-format generated output (run after generate if needed)
```

The generator reads the live OAS3 spec from `https://esi.evetech.net/meta/openapi.yaml?compatibility_date=2026-05-19`.

It emits:
- `src/Responses/*.php` — ~218 typed DTO classes (one per ESI schema object)
- `src/Resources/{Tag}/*.php` — 208 per-route static classes grouped by ESI tag (33 subfolders)
- `src/Resources/{Tag}Resource.php` — 33 flat tag-group wrapper classes for the fluent API

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
