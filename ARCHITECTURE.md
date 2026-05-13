# Architecture & Design Decisions — seatplus/esi-schema

This document records the key design decisions made for `seatplus/esi-schema`, with context, rationale, alternatives considered, and consequences. It is intended for contributors and for AI agents working in this repository.

---

## Decision 1 — One static class per ESI endpoint (Operation classes)

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
- **PHPStan traces return types** — `execute()` returns `EsiResult<GetCharactersCharacterIdAssetsItem>`, fully known at static analysis time. No generics workaround needed.
- **IDE navigation** — Ctrl+Click on a class name navigates to the endpoint's source. There is no string operationId to grep for.

### Alternatives considered
- **Instance methods on Resource classes** — still exists (Resources) for backwards compatibility and for cases where you want to call several endpoints on the same tag without repeating the transport argument.
- **String-keyed registry** — `EsiSchema::operation('getCharactersCharacterIdAssets')` — rejected because it requires runtime string-to-class resolution, is not statically analysable, and hides the return type.

### Consequences
- 208 files in `src/Resources/`. This is intentional and by design — each file is tiny (~30 lines).
- Adding a new ESI endpoint means regenerating, not adding a method to an existing class.

---

## Decision 2 — Typed public constants instead of an associative array

### Context
The original implementation stored all metadata for an operation in a single private array constant:
```php
private const array META = ['requiredScope' => '...', 'rateLimit' => [...], 'cacheAge' => 3600, ...];
```

### Decision
Each generated Operation class emits 7 individually typed `public const` declarations:

```php
public const ?string REQUIRED_SCOPE       = 'esi-assets.read_assets.v1';
public const ?string RATE_LIMIT_GROUP     = 'char-asset';
public const ?int    RATE_LIMIT_MAX_TOKENS = 1800;
public const ?string RATE_LIMIT_WINDOW    = '15m';
public const ?int    CACHE_AGE            = 3600;
public const array   REQUIRED_ROLES       = [];
public const bool    USES_CURSOR          = false;
```

### Rationale
- **Individual readability** — `GetCharactersCharacterIdAssets::REQUIRED_SCOPE` is directly accessible without instantiation or method call.
- **Type safety** — PHPStan sees `?string`, `?int`, `bool` — not `mixed` inside an `array<string,mixed>`. Each constant is typed at the PHP level (PHP 8.3 typed class constants).
- **Discoverability** — IDEs autocomplete constant names; array keys require knowing the schema.
- **No array parsing at call time** — `meta()` simply passes the constants into `new OperationMeta(...)`.

### Alternatives considered
- Keeping the array as `protected const` — rejected because it's still opaque to static analysis and external consumers.
- Generating a `readonly class` per endpoint with properties baked in — more overhead, same information.

### Consequences
- Generated files are slightly longer per endpoint (+~15 lines) but more readable.
- Changes to the constant set (adding a new metadata field) require regeneration and a version bump.

---

## Decision 3 — `OperationMeta` as a pure typed DTO (no logic)

### Context
The original `OperationMeta` used `HasOperationMeta` trait to add accessor methods (`requiredScope()`, `cacheAge()`, …) and also contained a `tokenSatisfies(array $scopes): bool` helper method.

### Decision
`OperationMeta` is a `final readonly class` with only typed constructor properties and no methods beyond what a DTO needs:

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

**`tokenSatisfies()` was removed entirely.** Scope validation is eveapi's responsibility, not the schema library's.

### Rationale
- **Single responsibility** — the schema library describes ESI's type system. Whether a given token satisfies a scope requirement is application logic that belongs in eveapi, where the token models live.
- **No methods needed** — with typed public readonly properties, consumers access `$meta->requiredScope` directly. Adding methods would be redundant sugar.
- **`from(?array)` removed** — the array-parsing factory was only needed when metadata was stored as arrays. Now it is generated directly from typed constants, so `new OperationMeta(...)` is the constructor.

### Alternatives considered
- Keeping `tokenSatisfies()` as a convenience — rejected because it creates a logic dependency in a data library and tests were redundant with what eveapi would test anyway.
- Adding `HasOperationMeta` to `OperationMeta` for method-style access — rejected because the trait is for result objects (`EsiResult`, `AbstractEsiDto`) that need backwards-compatible method accessors. `OperationMeta` itself should be a simple struct.

### Consequences
- Consumers that called `$meta->tokenSatisfies($scopes)` must implement this check themselves (one line: `$meta->requiredScope === null || in_array($meta->requiredScope, $scopes, true)`).
- `OperationMeta` properties accessed as `$meta->requiredScope` (property), while post-call accessors on results remain as `$result->requiredScope()` (method via `HasOperationMeta` trait). This asymmetry is intentional — see Decision 4.

---

## Decision 4 — `HasOperationMeta` as a trait on result objects only

### Context
`EsiResult<T>` (array endpoints) and `AbstractEsiDto` (object endpoints) both need metadata accessors post-call. `OperationMeta` is the pre-call object. All three originally shared one trait.

### Decision
`HasOperationMeta` trait is used **only** by `EsiResult` and `AbstractEsiDto`. It provides backwards-compatible method-style accessors (`rateLimitGroup()`, `cacheAge()`, etc.) that delegate to the held `?OperationMeta $operationMeta` property:

```php
public function rateLimitGroup(): ?string
{
    return $this->operationMeta?->rateLimitGroup;
}
```

`OperationMeta` itself does **not** use this trait — its properties are accessed directly.

### Rationale
- **`EsiResult` is `readonly class`** — cannot extend an abstract class. A trait is the only way to share behaviour with `AbstractEsiDto`.
- **Backwards compatibility for result objects** — code that calls `$result->rateLimitGroup()` continues to work. Changing result accessors from methods to properties would be a breaking change for consumers of the library.
- **`OperationMeta` is a DTO, not a result** — it does not need the method wrappers.

### Alternatives considered
- Single abstract base class for all three — impossible because `readonly class` cannot extend a non-`readonly` abstract class in PHP.
- Making everything properties on results too — breaking change for existing consumers.

### Consequences
- There is a deliberate asymmetry: `$meta->requiredScope` (property on `OperationMeta`) vs `$result->requiredScope()` (method on results via trait). This is documented in the copilot instructions.

---

## Decision 5 — Tag-based subfolders for Operation classes

### Context
With 208 operation classes, a flat `src/Resources/` directory is hard to navigate.

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
- **Mirrors the Resource layer** — `Resources\Assets\` maps directly to `AssetsResource`. Consistent mental model.
- **Group imports** — `use Seatplus\EsiSchema\Resources\Assets\{GetCharactersCharacterIdAssets, PostCharactersCharacterIdAssetsLocations}` is idiomatic PHP.
- **IDE folder navigation** — 33 folders of ~6 files each vs 208 files flat.

### Alternatives considered
- Flat directory — simple but unnavigable at 208 files.
- HTTP-method grouping (GET/, POST/) — doesn't match how ESI is documented or how consumers think about endpoints.

### Consequences
- Import paths are one level deeper: `Resources\Assets\GetCharactersCharacterIdAssets` vs `Resources\GetCharactersCharacterIdAssets`.
- Composer PSR-4 autoloading covers all subnamespaces automatically — no `composer.json` change needed.

---

## Decision 6 — Zero runtime dependencies

### Context
ESI schema information could be fetched at runtime from the OpenAPI spec, or stored in a JSON file bundled with the library.

### Decision
The library has **no `require` entries** in `composer.json`. `symfony/yaml` is `require-dev` only (used by `bin/generate.php`). All metadata is baked into generated PHP constants.

### Rationale
- **0ms overhead** — no network, no file I/O, no JSON/YAML parsing at runtime.
- **No version conflicts** — consumers cannot have a dependency conflict on a library this package doesn't require.
- **No transport assumptions** — the library is agnostic about HTTP client, serializer, and framework.

### Alternatives considered
- Bundle a JSON metadata file + read at runtime — adds I/O, adds a deserialization step, doesn't improve type safety.
- Runtime spec fetch — adds latency, adds a network dependency, risks spec drift mid-request.

### Consequences
- Schema changes require regeneration and a new release. ESI spec drift is a deploy-time concern, not a runtime concern.
- The generator (`bin/generate.php`) is the only file that needs `symfony/yaml`. It is not shipped to end users.

---

## Decision 7 — `EsiTransportInterface` as the sole injection boundary

### Context
An ESI library needs to make HTTP calls. Several approaches exist: bundle an HTTP client, accept a PSR-18 client, or define a minimal custom interface.

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

All HTTP concerns (OAuth, RFC 7234 caching, error-limit tracking, retry) are delegated to the implementation. The library is not coupled to any specific HTTP client.

### Rationale
- **Consumers own the HTTP layer** — they choose Guzzle, curl, Symfony HttpClient, or a mock.
- **Tests use a mock** — no network required for the entire test suite.
- **Single seam** — when ESI changes its auth model, only the transport changes, not this library.

### Alternatives considered
- PSR-18 `ClientInterface` — too low-level (no OAuth, no path-value substitution, no caching semantics).
- Bundling an HTTP client — forces version constraints on consumers and couples schema to transport.

### Consequences
- The reference implementation is [seatplus/esi-client](https://github.com/seatplus/esi-client). Consumers are responsible for choosing and wiring their transport.

---

## Decision 8 — Library major version = ESI compatibility_date

### Context
ESI uses [`compatibility_date`](https://github.com/esi/esi-docs/blob/main/docs/services/esi) to gate breaking changes behind an opt-in date. Consumers choose their date by including it in API requests.

### Decision
The library's major version tracks the `compatibility_date` in use. `1.x` uses `2025-12-16`. When CCP publishes a new breaking date, a `2.x` branch is created with freshly generated types.

| Library major | ESI compatibility_date | Composer |
|---|---|---|
| `1.x` | `2025-12-16` | `^1.0` |

### Rationale
- **Unambiguous compatibility** — the version number tells you exactly which spec the types represent.
- **Stable `1.x`** — non-breaking spec changes (new fields, same date) are `1.x` patches. Consumers on `^1.0` never get unexpected breaking changes.
- **Regeneration is cheap** — because the generator is a single PHP script, producing a `2.x` from a new spec is a one-command operation.

### Alternatives considered
- Semver based on ESI's own versioning — ESI does not publish semver; its versioning is date-based.
- Single branch that always tracks latest — would force consumers to update when spec changes break types.

### Consequences
- Upgrading from `1.x` to `2.x` requires updating import paths if type shapes changed. The changelog will document which schemas changed.

---

## Decision 9 — Resource classes retained for backwards compatibility

### Context
The original API was tag-based Resource instances: `new AssetsResource($transport)`. The Operation classes are a newer, preferred API.

### Decision
Resource classes remain fully functional. They are not deprecated. Each Resource generates:
1. Instance methods (original API): `$resource->getCharactersCharacterIdAssets(...)`
2. Static companion methods: `AssetsResource::getCharactersCharacterIdAssetsMeta()` → delegates to `GetCharactersCharacterIdAssets::meta()`
3. Static `metaFor(string $operationId)` → `match` expression delegating to Operation classes

### Rationale
- **No breaking changes** — existing code continues to work.
- **Resource is still useful** — when calling several endpoints on the same tag, sharing one `$resource` instance avoids repeating the transport argument.
- **No duplicated metadata** — Resource methods and Operation classes share the same `OperationMeta` source of truth via direct delegation (`GetCharactersCharacterIdAssets::meta()`). There is only one place to change metadata.

### Alternatives considered
- Deprecating Resources — rejected until a major version bump; no value in breaking existing users.
- Resources owning their own OPERATION_META arrays — rejected because metadata would be duplicated and could drift from the Operation class constants.

### Consequences
- Operation classes are the canonical API for new code.
- Resources are a thin wrapper — they add no metadata of their own, only convenience.
