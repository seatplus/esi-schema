# GitHub Copilot Instructions — seatplus/esi-schema

## What this repository is

`seatplus/esi-schema` is a **code-generated PHP library** that wraps the EVE Online ESI (Swagger/OpenAPI) API. It provides:

- **208 Operation classes** (`src/Resources/{Tag}/`) — one static class per ESI endpoint, with typed `meta()` and `execute()` methods.
- **33 Resource classes** (`src/Resources/`) — legacy tag-grouped instance API (backwards-compatible).
- **~218 DTO classes** (`src/Responses/`) — typed value objects for every ESI response schema.
- **Zero runtime dependencies** — pure PHP 8.3, no Guzzle, no HTTP client, no framework.

All files under `src/Responses/`, `src/Resources/`, and `src/Resources/` are **generated**. Do not edit them directly.

---

## The absolute rule: never edit generated files

The following directories contain **only generated code**:

```
src/Responses/        ← ~218 DTO classes, one per ESI schema object
src/Resources/        ← 33 tag Resource classes
src/Resources/       ← 208 operation classes in 33 tag subfolders
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
  generate.php              # The generator — reads ESI OpenAPI spec, emits all 459 files

src/
  Contracts/
    EsiOperationInterface.php  # Interface for Operation classes: static meta(): OperationMeta
    EsiTransportInterface.php  # Interface for HTTP transport: invoke() → EsiRawResponse
    EsiRawResponse.php         # Value object: raw HTTP response data
    EsiCursor.php              # Cursor pagination tokens (before/after)
  Concerns/
    HasOperationMeta.php       # Trait: 7 metadata accessors (rateLimitGroup, cacheAge, …)
  AbstractEsiDto.php           # Base class for all single-object DTO responses
  EsiResult.php                # Generic typed wrapper for array/paginated responses
  OperationMeta.php            # Pre-call metadata DTO (from Operation::meta())

  Responses/                   # GENERATED — ~218 typed DTO classes
  Resources/                   # GENERATED — 33 tag-based resource classes
  Resources/                  # GENERATED — 208 operation classes in 33 subfolders
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
    OperationTest.php          # Tests for Operation classes (meta + execute)
    …

phpunit.xml
phpstan.neon.dist
pint.json
composer.json
```

---

## Key contracts

### `EsiOperationInterface`
Every Operation class implements this. It has one method:
```php
public static function meta(): OperationMeta;
```
Operation classes also expose a typed `static execute(EsiTransportInterface $transport, ...): EsiResult|AbstractEsiDto` but that method's signature varies per endpoint (different path/query params), so it is not part of the interface.

### `EsiTransportInterface`
The single injection boundary. Implementations handle HTTP, OAuth, caching. This library does not import any HTTP client.
```php
public function invoke(string $method, string $path, array $pathValues, array $queryParams, array $requestBody): EsiRawResponse;
```

### `OperationMeta`
Pre-call DTO. Built from the `OPERATION_META` constant baked into each Operation class at generation time.
Accessors: `requiredScope()`, `rateLimitGroup()`, `rateLimitMaxTokens()`, `rateLimitWindow()`, `cacheAge()`, `requiredRoles()`, `usesCursor()`, `tokenSatisfies(array $scopes)`.

### `HasOperationMeta` (trait)
Mixed into `EsiResult<T>`, `AbstractEsiDto`, and `OperationMeta`. Provides the same 7 accessors on both pre-call and post-call objects.

---

## Operation class namespace pattern

```
Seatplus\EsiSchema\Resources\{Tag}\{PascalCaseOperationId}
```

Tag names map from ESI tags with spaces stripped in PascalCase:
- `Assets` → `Resources\Assets\`
- `Faction Warfare` → `Resources\FactionWarfare\`
- `Corporation` → `Resources\Corporation\`

Usage example:
```php
use Seatplus\EsiSchema\Resources\Assets\GetCharactersCharacterIdAssets;

// Pre-call check (no transport needed)
$meta = GetCharactersCharacterIdAssets::meta();
if (!$meta->tokenSatisfies($token->scopes)) {
    throw new MissingScopeException($meta->requiredScope());
}

// Call
$result = GetCharactersCharacterIdAssets::execute($transport, characterId: 12345, page: 1);
foreach ($result->data as $item) {
    echo $item->type_id;   // typed int
}
```

---

## OPERATION_META — how metadata is stored

Each generated Operation class contains a private constant:
```php
private const array OPERATION_META = [
    'requiredScope' => 'esi-assets.read_assets.v1',   // null for public endpoints
    'rateLimit'     => ['group' => 'char-asset', 'max-tokens' => 1800, 'window-size' => '15m'],
    'cacheAge'      => 3600,
    'requiredRoles' => [],        // ['Director'] for corp endpoints
    'cursor'        => false,     // true for cursor-paginated endpoints
];
```

This constant is populated by `bin/generate.php` from the ESI OpenAPI spec's `x-esi-*` extension fields. There is no runtime spec fetch — metadata is always available at zero cost.

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
| Edit `bin/generate.php` to change generated output | Edit files in `src/Responses/`, `src/Resources/`, `src/Resources/` directly |
| Edit handwritten files in `src/Contracts/`, `src/Concerns/`, `src/AbstractEsiDto.php`, `src/EsiResult.php`, `src/OperationMeta.php` | Add runtime dependencies to `composer.json` `require` |
| Write tests in `tests/` | Introduce framework-specific code (no Laravel, no Symfony) |
| Run `vendor/bin/pint` after regenerating | Skip the `composer test` check before committing |
| Keep `HasOperationMeta` as a trait | Introduce an abstract base class that tries to share metadata logic |

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
