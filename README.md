# seatplus/esi-schema

**Typed ESI schema for PHP.** Every EVE Online ESI endpoint has its own generated class with typed pre-call metadata and a typed call method — no magic strings, no `array` guesswork.

Generated from the ESI OpenAPI spec. Zero runtime dependencies.

The compatibility date a given install was generated for is `Seatplus\EsiSchema\GeneratedSpec::COMPATIBILITY_DATE` — see [Versioning](#versioning).

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

Resource classes are grouped by ESI tag into 36 subfolders, each with a corresponding tag-group wrapper:

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
| … (36 total) | | |

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
       ├── Resources/{Tag}Resource  # 36 generated tag wrappers — fluent API entry points
       │    └── AssetsResource
       │         ├── __construct(EsiTransportInterface $transport)
       │         └── getCharactersCharacterIdAssets($id, $page)  # delegates to ↓
       │
       └── Resources/{Tag}/         # 218 generated classes — one per ESI endpoint
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

The 218 resource classes live in `src/Resources/{Tag}/` (36 subfolders), matching ESI's tag taxonomy:

- **Group imports** are idiomatic: `use Seatplus\EsiSchema\Resources\Assets\{GetCharactersCharacterIdAssets, GetCorporationsCorporationIdAssets}`.
- Tag names with spaces become PascalCase: `Faction Warfare` → `FactionWarfare`.

### 5. Zero runtime dependencies

`composer.json` has **no `require` entries** (only `require-dev` for `symfony/yaml` used by the generator). The published library is pure PHP 8.3.

### 6. `EsiTransportInterface` as the sole injection boundary

All network I/O is delegated to a single `invoke()` method. The library knows nothing about Guzzle, cURL, OAuth tokens, or HTTP caching. Tests mock this interface — no network required.

### 7. The version is semver over the PHP surface; the ESI date is metadata

The library version describes **this package's PHP API**, not ESI's calendar. A new
compatibility date is data carried by a release, not a component of the version
number. See [Versioning](#versioning).

---

## Versioning

`seatplus/esi-schema` follows plain semver **over its generated PHP surface**:

| Bump | Means |
|---|---|
| **major** | The PHP API broke — a class, property, method or constant was removed or retyped, a property gained nullability, or a required parameter was added. |
| **minor** | The PHP API grew, **or** the ESI compatibility date advanced without breaking anything. |
| **patch** | Neither — metadata constant values (`CACHE_AGE`, rate limits), formatting, docs. |

A new compatibility date is therefore *at least* a minor — it changes the
`X-Compatibility-Date` a transport sends, which is real behaviour — but is never
automatically a major.

### How to pin

| You want | Use |
|---|---|
| Keep working, ride ESI forward (the default) | `^3.0` |
| Freeze the PHP surface, still take fixes | `~3.4.0` |
| Freeze one exact ESI compatibility date | an exact version, e.g. `3.4.2` |

Pinning an exact version is the only honest way to pin a date: a caret constraint
spans an open-ended range of future releases, so `^3.0` cannot express "the
2026-05-19 wire contract".

**There are no `N.x` branches.** Packagist serves every constraint from tags, and
generated code is committed, so every compatibility date this package ever shipped
remains installable at its own tag forever.

### Which date am I on?

```php
use Seatplus\EsiSchema\GeneratedSpec;

GeneratedSpec::COMPATIBILITY_DATE;         // '2026-05-19'
GeneratedSpec::COMPATIBILITY_DATE_HEADER;  // 'X-Compatibility-Date'
```

A transport **must** send `COMPATIBILITY_DATE_HEADER: COMPATIBILITY_DATE` on every
request. Reading it from here rather than hard-coding a literal is what keeps the
generated types and the server's response shape from disagreeing — a
`composer update` then moves both together.

### How releases happen

`.github/workflows/esi-sync.yml` runs daily. It regenerates against the newest
published compatibility date and compares the resulting API surface manifest
(`.esi/surface.json`) with the one in the newest semver tag:

- **nothing changed** → nothing happens;
- **patch or minor** → it opens a pull request with **auto-merge enabled**. CI runs,
  the required check passes, the PR merges itself, and `release.yml` tags it. No
  human involved.
- **major, or unclassifiable** → no pull request, nothing released; one issue is
  opened for a human, who reviews the report and dispatches `release.yml` with an
  explicit `bump=major`.

`release.yml` watches `main`, so a bot-merged sync and a human-merged PR take the
identical path to a tag. It refuses to auto-tag a major, refuses to re-tag an
existing version, and afterwards checks the release is actually resolvable on
Packagist.

Nothing in this pipeline bypasses branch protection — the bot goes through the same
required check as anyone else.

Majors are held back deliberately. Composer never force-upgrades a `^3.0` consumer
to `4.0.0`, but it also cannot protect anyone from a bug in the classifier
publishing a removal as a minor — and a Packagist tag cannot be withdrawn.

---

## Regenerating

```bash
php bin/generate.php --compatibility-date=2026-05-19
vendor/bin/pint         # generated output is raw; format it afterwards
```

Omit `--compatibility-date` for a local run and the newest published date is used.
It is **required** under `--strict` (implied in CI) so that an unattended run can
never guess which spec to build from.

The generator reads `https://esi.evetech.net/meta/openapi.yaml?compatibility_date=<date>`
and vendors the exact bytes it consumed to `.esi/openapi.yaml`, so the tree can be
reproduced offline:

```bash
php bin/generate.php --spec=.esi/openapi.yaml \
  --compatibility-date="$(jq -r .compatibility_date .esi/state.json)"
vendor/bin/pint && git diff --exit-code -- src/
```

It emits (current counts are asserted by `tests/Unit/GeneratedSpecTest.php` and
recorded in `GeneratedSpec`):

- `src/Responses/*.php` — 268 typed DTO classes, one per ESI schema object
- `src/Resources/{Tag}/*.php` — 218 per-route static classes in 36 tag subfolders
- `src/Resources/{Tag}Resource.php` — 36 tag-group wrappers for the fluent API
- `src/GeneratedSpec.php` — provenance constants
- `.esi/surface.json` — the public API manifest that drives release classification
- `.esi/state.json` — compatibility date, spec hash, manifest hash, counts

Generation **prunes**: anything under `src/Responses` or `src/Resources` that the
spec no longer describes is deleted. Without that, removed endpoints linger and no
diff can ever see a removal.

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
