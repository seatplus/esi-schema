# Architecture & Design Decisions — seatplus/esi-schema

This document records the key design decisions made for `seatplus/esi-schema`, with context, rationale, alternatives considered, and consequences. It is intended for contributors and for AI agents working in this repository.

---

## Decision 1 — One static class per ESI endpoint

### Context
ESI has ~208 endpoints. The original design used 33 tag-based Resource classes (e.g. `AssetsResource`) with one instance method per endpoint. Pre-call introspection required string-based lookups like `AssetsResource::metaFor('getCharactersCharacterIdAssets')`.

### Decision
Each ESI endpoint gets its own static class under `src/Resources/{Tag}/`. Class name = PascalCase operationId.

```php
use Seatplus\EsiSchema\Resources\Assets\GetCharactersCharacterIdAssets;

$meta   = GetCharactersCharacterIdAssets::meta();    // pre-call
$result = GetCharactersCharacterIdAssets::execute($transport, $characterId);
```

### Rationale
- **Zero allocation** — static calls require no `new`, no DI container, no service locator.
- **Class name = identifier** — `OPERATION = GetCharactersCharacterIdAssets::class` is a typed constant reference in eveapi jobs, not a magic string.
- **PHPStan traces return types** — `execute()` returns `EsiResult<GetCharactersCharacterIdAssetsItem>`, fully known at static analysis time.
- **IDE navigation** — Ctrl+Click on a class name navigates to the endpoint's source.

### Alternatives considered
- **Tag-grouped Resource instances** — `new AssetsResource($transport)` — this was the original API; replaced by per-route static classes because it required string operationIds for metadata lookup and obscured return types.
- **String-keyed registry** — `EsiSchema::operation('getCharactersCharacterIdAssets')` — rejected: requires runtime string-to-class resolution, not statically analysable, hides return type.

### Consequences
- 208 files in `src/Resources/`. Intentional — each file is tiny (~60 lines).
- Adding a new ESI endpoint means regenerating, not adding a method to an existing class.

---

## Decision 2 — Typed public constants instead of an associative array

### Context
An earlier implementation stored all metadata in a single private array constant:
```php
private const array OPERATION_META = ['requiredScope' => '...', 'rateLimit' => [...], 'cacheAge' => 3600, ...];
```

### Decision
Each generated class emits 7 individually typed `public const` declarations:

```php
public const ?string REQUIRED_SCOPE        = 'esi-assets.read_assets.v1';
public const ?string RATE_LIMIT_GROUP      = 'char-asset';
public const ?int    RATE_LIMIT_MAX_TOKENS = 1800;
public const ?string RATE_LIMIT_WINDOW     = '15m';
public const ?int    CACHE_AGE             = 3600;
public const array   REQUIRED_ROLES        = [];
public const bool    USES_CURSOR           = false;
```

### Rationale
- **Direct access** — `GetCharactersCharacterIdAssets::REQUIRED_SCOPE` is accessible without any method call or instantiation.
- **Type safety** — PHPStan sees `?string`, `?int`, `bool` — not `mixed` inside `array<string,mixed>`.
- **Discoverability** — IDEs autocomplete constant names; array keys are opaque strings.
- **No parsing** — `meta()` simply passes constants into `new OperationMeta(...)`.

### Alternatives considered
- Keeping the array as `protected const` — still opaque to static analysis.
- Generating a `readonly class` per endpoint with properties — more overhead, same information.

### Consequences
- Generated files are slightly longer (~+15 lines) but more readable.
- Adding a new metadata field requires regeneration and a version bump.

---

## Decision 3 — `OperationMeta` as a pure typed DTO (no logic)

### Context
An earlier `OperationMeta` included a `tokenSatisfies(array $scopes): bool` helper method. The class also originally went through `HasOperationMeta` trait for method-style accessors.

### Decision
`OperationMeta` is a `final readonly class` with only typed constructor properties. No methods:

```php
final readonly class OperationMeta
{
    public function __construct(
        public readonly ?string $requiredScope = null,
        public readonly ?string $rateLimitGroup = null,
        public readonly ?int    $rateLimitMaxTokens = null,
        public readonly ?string $rateLimitWindow = null,
        public readonly ?int    $cacheAge = null,
        public readonly array   $requiredRoles = [],
        public readonly bool    $usesCursor = false,
    ) {}
}
```

**`tokenSatisfies()` was removed entirely.** Scope validation belongs in eveapi, not in a schema-description library.

### Rationale
- **Single responsibility** — this library describes ESI's type system. Whether a token satisfies a scope is application logic (the token model lives in eveapi).
- **No method wrappers needed** — with typed `public readonly` properties, `$meta->requiredScope` is direct property access; methods would be redundant sugar.

### Alternatives considered
- Keeping `tokenSatisfies()` as convenience — rejected: logic dependency in a data library; duplicates what eveapi tests anyway.
- Adding accessor methods to `OperationMeta` — rejected: adds noise to a DTO; property access is cleaner.

### Consequences
- Scope check: `$meta->requiredScope === null || in_array($meta->requiredScope, $scopes, true)`.
- `OperationMeta` properties are accessed directly (`$meta->requiredScope`). No method call needed.

---

## Decision 4 — Result objects carry no operation metadata

### Context
Earlier versions of `EsiResult<T>` and `AbstractEsiDto` carried an `?OperationMeta $operationMeta` property (injected after execution) and a `HasOperationMeta` trait that exposed `rateLimitGroup()`, `cacheAge()`, etc. as methods on the result.

### Decision
`EsiResult` and `AbstractEsiDto` carry **only transport-level data**: `data`, `pages`, `isCachedLoad`. No `operationMeta` property. No `HasOperationMeta` trait.

```php
readonly class EsiResult
{
    public function __construct(
        public mixed $data,
        public int   $pages = 1,
        public bool  $isCachedLoad = false,
    ) {}
}
```

### Rationale
- **Redundant by design** — you always know which operation you called. The metadata is available via `GetCharactersCharacterIdAssets::meta()` or `::REQUIRED_SCOPE` at any time without needing it on the result object.
- **No injection step** — removing `$dto->operationMeta = ...` from the generated execute() methods simplifies the generated code.
- **`EsiResult` stays lean** — it is a typed wrapper for transport data, nothing more.
- **`HasOperationMeta` trait deleted** — the trait was only needed because both `EsiResult` (readonly class) and `AbstractEsiDto` (abstract class) needed the same accessors. Once the accessors were removed from results, the trait had no purpose.

### Alternatives considered
- Keeping metadata on results for convenience — rejected: it was always redundant; the caller already has the class name.
- Keeping `HasOperationMeta` as a trait — rejected: nothing uses it anymore.

### Consequences
- Post-call metadata access: use `GetCharactersCharacterIdAssets::REQUIRED_SCOPE` or `::meta()` instead of `$result->requiredScope()`.
- `src/Concerns/HasOperationMeta.php` was deleted.

---

## Decision 5 — Tag-based subfolders for Resource classes

### Context
With 208 resource classes, a flat `src/Resources/` directory is hard to navigate.

### Decision
Resource classes are grouped into 33 tag subfolders matching ESI's tag taxonomy:

```
src/Resources/
├── Assets/         (6 classes)
├── Character/      (14 classes)
├── Corporation/    (22 classes)
├── FactionWarfare/ (8 classes)
├── Market/         (11 classes)
├── Universe/       (30 classes)
...
```

Namespace: `Seatplus\EsiSchema\Resources\{Tag}\{OperationId}`.  
Tags with spaces become PascalCase: `Faction Warfare` → `FactionWarfare`.

### Rationale
- **Group imports** are idiomatic: `use Seatplus\EsiSchema\Resources\Assets\{GetCharactersCharacterIdAssets, PostCharactersCharacterIdAssetsLocations}`.
- **IDE folder navigation** — 33 folders of ~6 files each vs 208 files flat.

### Alternatives considered
- Flat directory — simple but unnavigable at 208 files.
- HTTP-method grouping — doesn't match how ESI is documented or how consumers think.

### Consequences
- Import paths include one tag-level segment: `Resources\Assets\GetCharactersCharacterIdAssets`.
- Composer PSR-4 autoloading covers all subnamespaces automatically.

---

## Decision 6 — Zero runtime dependencies

### Context
ESI schema information could be fetched at runtime or stored as a bundled JSON file.

### Decision
The library has **no `require` entries** in `composer.json`. `symfony/yaml` is `require-dev` only (used by `bin/generate.php`). All metadata is baked into generated PHP constants.

### Rationale
- **0ms overhead** — no network, no file I/O, no JSON/YAML parsing at runtime.
- **No version conflicts** — consumers cannot have a dependency conflict on a library this package doesn't require.

### Consequences
- Schema changes require regeneration and a new release. ESI spec drift is a deploy-time concern, not a runtime concern.

---

## Decision 7 — `EsiTransportInterface` as the sole injection boundary

### Context
An ESI library needs to make HTTP calls.

### Decision
A single interface with one method:

```php
interface EsiTransportInterface
{
    public function invoke(
        string $method,
        string $path,
        array $pathValues = [],
        array $queryParams = [],
        array $requestBody = [],
    ): EsiRawResponse;
}
```

All HTTP concerns (OAuth, RFC 7234 caching, error-limit tracking, retry) are delegated to the implementation.

### Rationale
- **Tests use a mock** — no network required for the entire test suite.
- **Single seam** — when ESI changes its auth model, only the transport changes.

### Alternatives considered
- PSR-18 `ClientInterface` — too low-level (no OAuth, no path-value substitution).
- Bundling an HTTP client — forces version constraints on consumers.

### Consequences
- Reference implementation: [seatplus/esi-client](https://github.com/seatplus/esi-client).

---

## Decision 8 — Library major version = ESI compatibility_date

### Context
ESI uses `compatibility_date` to gate breaking changes behind an opt-in date.

### Decision
The library's major version tracks the `compatibility_date` in use:

| Library major | ESI compatibility_date | Composer |
|---|---|---|
| `1.x` | `2025-12-16` | `^1.0` |

### Rationale
- **Unambiguous compatibility** — the version number tells you which spec the types represent.
- **Regeneration is cheap** — the generator is a single PHP script.

### Consequences
- Upgrading from `1.x` to `2.x` may require updating import paths if type shapes changed.

---

## Decision 9 — Tag-grouped Resource classes removed

### Context
The original API was tag-based Resource instances: `new AssetsResource($transport)` with instance methods like `getCharactersCharacterIdAssets(...)`. A subsequent refactor added per-route Operation classes as a new preferred API, with Resources as a "backwards-compatible" wrapper.

### Decision
The tag-grouped Resource classes (`AssetsResource`, `AllianceResource`, etc.) were **deleted**. The 33 `{Tag}Resource.php` files and `AbstractResource.php` no longer exist.

The per-route classes in `src/Resources/{Tag}/` are the **only** API.

### Rationale
- **Two APIs doing the same thing** — both called `$transport->invoke()` through the same generated code path. The Resource layer added no unique value.
- **String-based `metaFor()`** — `AssetsResource::metaFor('getCharactersCharacterIdAssets')` was exactly the "magic string lookup" the per-route class design was meant to eliminate.
- **Maintenance surface** — two generated layers doubled the files to maintain and the places that could drift out of sync.
- **Clean naming** — `src/Resources/{Tag}/GetCharactersCharacterIdAssets` is now the only thing called a "Resource", and it is self-contained.

### Alternatives considered
- Keeping Resources for users who want to pass `$transport` once — rejected: not enough value to justify two APIs. Users can hold `$transport` themselves.
- Deprecating instead of deleting — rejected at `1.x` pre-release stage; no existing consumers to protect.

### Consequences
- Code using `new AssetsResource($transport)->getCharactersCharacterIdAssets(...)` must migrate to `GetCharactersCharacterIdAssets::execute($transport, ...)`.
- `bin/generate.php` emits only DTOs and per-route Resource classes — 218 + 208 files.
