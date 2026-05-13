# GitHub Copilot Instructions — seatplus/esi-schema

## What this repository is

`seatplus/esi-schema` is a **code-generated PHP library** that wraps the EVE Online ESI (Swagger/OpenAPI) API. It provides:

- **208 per-route Resource classes** (`src/Resources/{Tag}/`) — one static class per ESI endpoint, with typed constants, `meta()`, and `execute()`.
- **33 tag-group wrapper classes** (`src/Resources/{Tag}Resource.php`) — one per ESI tag; store the transport and delegate to the per-route statics. Entry points for the fluent API.
- **~218 DTO classes** (`src/Responses/`) — typed value objects for every ESI response schema.
- **Zero runtime dependencies** — pure PHP 8.3, no Guzzle, no HTTP client, no framework.

---

## The absolute rule: never edit generated files

The following directories contain **only generated code**:

```
src/Responses/        ← ~218 DTO classes, one per ESI schema object
src/Resources/        ← 33 flat tag wrapper classes + 208 per-route classes in 33 subfolders
```

If you need to change generated output, **edit `bin/generate.php`**, then re-run:

```bash
php bin/generate.php
vendor/bin/pint       # auto-format if needed
```

Hand-editing a generated file will be overwritten the next time the generator runs.

---

## Repository layout

```
bin/
  generate.php              # The generator — reads ESI OpenAPI spec, emits all ~426 files

src/
  Contracts/
    EsiOperationInterface.php  # Interface for Resource classes: static meta(): OperationMeta
    EsiTransportInterface.php  # Interface for HTTP transport: invoke() → EsiRawResponse
    EsiRawResponse.php         # Value object: raw HTTP response data
    EsiCursor.php              # Cursor pagination tokens (before/after)
  Concerns/                    # (empty — HasOperationMeta trait was removed)
  AbstractEsiDto.php           # Base class for single-object DTO responses ($isCachedLoad, $pages)
  EsiResult.php                # Generic typed wrapper for array/paginated responses
  OperationMeta.php            # Pre-call metadata DTO (from Resource::meta())

  Responses/                   # GENERATED — ~218 typed DTO classes
  Resources/                   # GENERATED — 33 flat tag wrappers + 208 per-route classes
    AssetsResource.php           # tag wrapper — fluent entry: new AssetsResource($transport)
    CharacterResource.php        # tag wrapper
    MarketResource.php           # tag wrapper
    …  (33 flat files total)
    Assets/
      GetCharactersCharacterIdAssets.php
      GetCorporationsCorporationIdAssets.php
      …
    Market/
      GetMarketsPrices.php
      …
    (33 tag subfolders total)

tests/
  Unit/
    ResourceTest.php           # Tests for Resource classes (execute + typed results)
    OperationTest.php          # Tests for meta(), typed constants, EsiOperationInterface
    …

phpunit.xml
phpstan.neon.dist
pint.json
composer.json
```

---

## Key contracts

### `EsiOperationInterface`
Every Resource class implements this. It has one method:
```php
public static function meta(): OperationMeta;
```
Resource classes also expose a typed `static execute(EsiTransportInterface $transport, ...): EsiResult|AbstractEsiDto` — signature varies per endpoint, so not on the interface.

### `EsiTransportInterface`
The single injection boundary. Implementations handle HTTP, OAuth, caching. This library does not import any HTTP client.
```php
public function invoke(string $method, string $path, array $pathValues, array $queryParams, array $requestBody): EsiRawResponse;
```

### `OperationMeta`
Pre-call DTO. A `final readonly class` — **access properties directly**, no accessor methods:
```php
$meta = GetCharactersCharacterIdAssets::meta();
$meta->requiredScope;       // ?string — 'esi-assets.read_assets.v1' or null
$meta->rateLimitGroup;      // ?string
$meta->rateLimitMaxTokens;  // ?int
$meta->rateLimitWindow;     // ?string
$meta->cacheAge;            // ?int
$meta->requiredRoles;       // array (e.g. ['Director'])
$meta->usesCursor;          // bool
```

### `EsiResult<T>`
Returned by array/paginated endpoints. Carries **transport data only** — no operation metadata:
```php
$result->data;         // typed array of DTOs (or mixed)
$result->pages;        // int — total pages from X-Pages header
$result->isCachedLoad; // bool — true when served from RFC 7234 cache
```
For metadata, call the static constants or `meta()` on the class you just called.

### `AbstractEsiDto`
Base for single-object endpoint responses. Carries `$isCachedLoad` and `$pages` only — no operation metadata.

---

## Typed constants on Resource classes

Each generated Resource class exposes 7 typed `public const` declarations. Access them **without** instantiation or method call:

```php
GetCharactersCharacterIdAssets::REQUIRED_SCOPE;        // 'esi-assets.read_assets.v1'
GetCharactersCharacterIdAssets::RATE_LIMIT_GROUP;      // 'char-asset'
GetCharactersCharacterIdAssets::RATE_LIMIT_MAX_TOKENS; // 1800
GetCharactersCharacterIdAssets::RATE_LIMIT_WINDOW;     // '15m'
GetCharactersCharacterIdAssets::CACHE_AGE;             // 3600
GetCharactersCharacterIdAssets::REQUIRED_ROLES;        // []
GetCharactersCharacterIdAssets::USES_CURSOR;           // false
```

`meta()` simply wraps these into `new OperationMeta(...)`. Prefer constants when you only need one value.

---

## Resource class namespace patterns

**Per-route static classes:**
```
Seatplus\EsiSchema\Resources\{Tag}\{PascalCaseOperationId}
```

**Tag-group wrapper classes (fluent API):**
```
Seatplus\EsiSchema\Resources\{Tag}Resource
```

Tags with spaces become PascalCase:
- `Assets` → `Resources\Assets\` + `Resources\AssetsResource`
- `Faction Warfare` → `Resources\FactionWarfare\` + `Resources\FactionWarfareResource`
- `Corporation` → `Resources\Corporation\` + `Resources\CorporationResource`

Usage examples:

**Static API (preferred for jobs and services — no allocation):**
```php
use Seatplus\EsiSchema\Resources\Assets\GetCharactersCharacterIdAssets;

// Pre-call check (no transport needed)
$requiredScope = GetCharactersCharacterIdAssets::REQUIRED_SCOPE;
if ($requiredScope !== null && !in_array($requiredScope, $token->scopes, true)) {
    throw new MissingScopeException($requiredScope);
}

// Call
$result = GetCharactersCharacterIdAssets::execute($transport, characterId: 12345, page: 1);
foreach ($result->data as $item) {
    echo $item->type_id;   // typed int
}
```

**Fluent API (convenient when transport is already held):**
```php
use Seatplus\EsiSchema\Resources\AssetsResource;

$assets = new AssetsResource($transport);
$result = $assets->getCharactersCharacterIdAssets(characterId: 12345, page: 1);

// With esi-client's EsiClient (implements EsiTransportInterface):
$result = $esiClient->withToken($accessToken)->assets()->getCharactersCharacterIdAssets(12345);
```

Tag wrapper methods are **pure delegation** — they call the per-route static's `execute()` and return its result unchanged. All metadata (constants, `meta()`) remains on the per-route class.

---

## How to run tests

All test commands run from the repository root:

```bash
composer test               # Full suite: lint + PHPStan + type-coverage + Pest
composer test:unit          # Pest unit tests only
composer test:types         # PHPStan static analysis
composer test:type-coverage # Pest --type-coverage --min=100
composer lint               # Pint auto-format (modifies files)
```

**100% type coverage is required.** PHPStan is configured at max level via `phpstan.neon.dist`.

Tests use an in-memory mock of `EsiTransportInterface`. No network access required.

---

## Versioning policy

The library major version tracks the **ESI `compatibility_date`** in use:

| Library major | ESI compatibility_date |
|---|---|
| `1.x` | `2025-12-16` |

When CCP introduces a new breaking spec date, a new major version is created. Regenerate with:
```bash
php bin/generate.php --compatibility-date=YYYY-MM-DD
```

---

## What to do and what NOT to do

| ✅ Do | ❌ Don't |
|---|---|
| Edit `bin/generate.php` to change generated output | Edit files in `src/Responses/` or `src/Resources/` directly |
| Edit handwritten files: `src/Contracts/`, `src/AbstractEsiDto.php`, `src/EsiResult.php`, `src/OperationMeta.php` | Add runtime dependencies to `composer.json` `require` |
| Access metadata via typed constants (`::REQUIRED_SCOPE`) or `::meta()` | Expect `$result->requiredScope()` — results carry no metadata (use the class) |
| Access `OperationMeta` properties directly (`$meta->requiredScope`) | Call `$meta->requiredScope()` — there are no accessor methods on `OperationMeta` |
| Write tests in `tests/` | Introduce framework-specific code (no Laravel, no Symfony) |
| Run `vendor/bin/pint` after regenerating | Skip the `composer test` check before committing |
| Use the fluent API via `{Tag}Resource` when injecting transport once | Embed transport-call logic in tag wrapper methods — they must only delegate to the static |

---

## ESI spec reference

- OpenAPI YAML: `https://esi.evetech.net/meta/openapi.yaml?compatibility_date=2025-12-16`
- ESI docs: `https://github.com/esi/esi-docs`
- Rate limit groups: `https://github.com/esi/esi-docs/tree/main/docs/services/esi`

The generator fetches the spec automatically. To use a local file: `php bin/generate.php --spec=/path/to/openapi.yaml`.

---

## Commit conventions

Use conventional commits:
- `feat:` for new features (usually spec updates)
- `fix:` for bug fixes in handwritten code or generator
- `refactor:` for restructuring without behaviour change
- `docs:` for documentation-only changes
- `chore:` for generator/CI/config changes

Always include the co-author trailer:
```
Co-authored-by: Copilot <223556219+Copilot@users.noreply.github.com>
```
