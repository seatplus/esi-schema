# Architecture & Design Decisions — seatplus/esi-schema

This document records the key design decisions made for `seatplus/esi-schema`, with context, rationale, alternatives considered, and consequences. It is intended for contributors and for AI agents working in this repository.

---

## Decision 1 — One static class per ESI endpoint

### Context
ESI has ~218 endpoints. The original design used 33 tag-based Resource classes (e.g. `AssetsResource`) with one instance method per endpoint. Pre-call introspection required string-based lookups like `AssetsResource::metaFor('getCharactersCharacterIdAssets')`.

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
- 218 files in `src/Resources/`. Intentional — each file is tiny (~60 lines).
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
With 218 resource classes, a flat `src/Resources/` directory is hard to navigate.

### Decision
Resource classes are grouped into 36 tag subfolders matching ESI's tag taxonomy:

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
- **IDE folder navigation** — 36 folders of ~6 files each vs 218 files flat.

### Alternatives considered
- Flat directory — simple but unnavigable at 218 files.
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

## Decision 8 — ~~Library major version = ESI compatibility_date~~ (SUPERSEDED by Decision 10)

Kept for the record. This decision failed in production; the postmortem is the
valuable part.

### Original context
ESI uses `compatibility_date` to gate breaking changes behind an opt-in date.

### Original decision
The library's major version tracked the `compatibility_date` in use, with a
long-lived `N.x` freeze branch per date. A daily action regenerated onto a new
`N.x` branch and opened a `[REVIEW ONLY]` pull request that was explicitly
labelled **DO NOT MERGE**, to be merged and hand-tagged by a maintainer.

### What actually happened

Between 2026-05-20 and 2026-08-03 the scheme produced **56 major-version branches
(`1.x`…`56.x`) for 3 distinct compatibility dates**, 55 unmerged pull requests, 56
junk `N.x-dev` versions on Packagist, and **zero releases**. `main` stayed on
`2026-05-19` for two and a half months while the README claimed it was "always the
latest". `git diff origin/3.x origin/39.x` is empty: 37 of those branches were one
identical tree.

Four causes, none of which were the version scheme alone:

1. **The pull requests were unmergeable, not merely ignored.** The action pushed
   with `GITHUB_TOKEN`, and `GITHUB_TOKEN`-authored events do not trigger
   workflows. CI therefore never ran on any bot branch, so `main`'s required status
   check never reported and every PR sat `BEHIND` forever. Nobody failed to merge
   them; nobody could.
2. **The dedup baseline was `main`,** which never advanced because the PRs were
   never merged — so every daily run saw the current date as new.
3. **Branch naming was `maxMajor+1`,** a counter that increments on *attempts*
   rather than outcomes.
4. **The date was stamped into all ~525 generated docblocks,** so a regeneration
   churned the whole tree. Of the 527-file `main`→`56.x` diff, only 20 files
   differed in anything else — a renamed operation and a reshaped DTO hid under 507
   files of noise.

And the scheme's own premise did not hold: **`^2.0` cannot encode a date.** A caret
constraint spans an open-ended range of future releases, so the moment any patch
landed on a freeze branch the date would drift. Worse, the freeze branches were
never installable at all — no tags were ever cut on them and `composer.json` has no
`branch-alias`, so `^56.0` could not resolve to anything. The advertised upgrade
path did not exist.

The general lesson, recorded because it outlives this repository: **a review gate
that fires on a schedule and is never actioned is worse than no gate.** It
accumulates artifacts, and any state derived from those artifacts silently rots.

---

## Decision 10 — Version is semver over the generated PHP surface

### Context
Decision 8 conflated two independent axes: the shape of this package's PHP API,
which changes rarely, and ESI's `compatibility_date`, which CCP moves roughly 4–8
times a year. Binding them made every CCP date a major, so consumers faced an
upgrade decision monthly for a diff that was usually a handful of new classes.

### Decision
The version number describes the **generated PHP surface**. The compatibility date
is data carried by a release, exposed as `GeneratedSpec::COMPATIBILITY_DATE`.

| Bump | Trigger |
|---|---|
| **major** | A class, property, method or constant was removed or retyped; a property gained nullability; a required parameter was added or parameters reordered; a return type or `@return` generic changed; a new in-game role became required. |
| **minor** | The surface grew (new class/property/constant, appended optional parameter); a property lost nullability; `REQUIRED_SCOPE` changed; **or** the compatibility date advanced without breaking anything. |
| **patch** | Metadata constant values (`CACHE_AGE`, `RATE_LIMIT_*`, `USES_CURSOR`), formatting, docs. |

A date advance is *at least* a minor, because a transport derives the
`X-Compatibility-Date` header from `GeneratedSpec` — so the date is observable
behaviour, not a comment. It is never automatically a major.

**No `N.x` branches.** Packagist serves every constraint from tags, and generated
code is committed, so each date remains installable at its own tag forever. To pin
a date, pin an exact version.

### Rationale
- **The verdict is mechanical.** `bin/api-diff.php` compares two
  `.esi/surface.json` manifests, so "is this breaking?" is computed, not argued.
- **The diff is reviewable.** With the per-file date stamp gone and pruning in
  place, a real change is ~20 files and the report is ~20 lines.
- **State cannot rot.** The baseline is the newest semver tag, read out of that
  tag's own tree — immutable, and exactly what a consumer can install.
- **Majors are not force-fed.** Composer never upgrades a `^3.0` consumer to
  `4.0.0`.

### Consequences
- Patch and minor releases are published unattended.
- A major is held back: `esi-sync.yml` opens one issue and a human dispatches
  `release.yml`. This is not Decision 8's gate returning — the artifact is a single
  reused issue rather than an accumulating pull request, the classifier explains
  exactly what broke, and nothing about the pipeline's future state depends on
  anyone acting on it.
- Anything the classifier cannot categorise escalates to `undecidable` and blocks
  the release. The bias is asymmetric on purpose: a needless major costs one
  version number nobody must take, whereas a break shipped as a minor reaches every
  consumer on their next `composer update` and a Packagist tag cannot be withdrawn.

---

## Decision 11 — Constructor argument order is not part of the contract

### Context
The generator emits promoted constructor parameters in spec property order. CCP
inserting a field mid-schema therefore reorders them, which would break positional
construction even though nothing was removed. Treating that as a major would make
almost every additive spec change breaking.

### Decision
DTOs under `src/Responses` are constructed **only** via `Dto::from($data)` or with
named arguments. Positional construction is unsupported, and parameter order is not
covered by semver.

`from()` already uses named arguments exclusively, and no consumer constructs a
`Responses\*` DTO directly.

### Consequences
- A property changing between required and optional, with its type unchanged, is a
  minor: it is reader-safe.
- This assumption is what lets additive syncs release as minors. Before adding a
  `new SomeResponseDto(...)` anywhere, note that doing so would invalidate it.

---

## Decision 9 — Tag-grouped Resource classes as fluent delegation wrappers

### Context
The original API was tag-based Resource instances: `new AssetsResource($transport)` with instance methods like `getCharactersCharacterIdAssets(...)`. Each method called `$this->transport->invoke(...)` directly. A subsequent refactor introduced per-route Operation classes (now called Resource classes in `src/Resources/{Tag}/`) with `static execute()` methods.

At one point the tag-grouped classes were removed entirely. However, `seatplus/esi-client` (and consumers that use its `$esiClient->assets()->getCharactersCharacterIdAssets(...)` fluent interface) depend on them. They were restored as thin delegation wrappers.

### Decision
The 36 flat `{Tag}Resource.php` files exist at `src/Resources/` alongside the per-route subdirectories. Each method delegates to its per-route static class:

```php
// src/Resources/AssetsResource.php
final class AssetsResource
{
    public function __construct(private readonly EsiTransportInterface $transport) {}

    public function getCharactersCharacterIdAssets(int $characterId, int $page = 1): EsiResult
    {
        return GetCharactersCharacterIdAssets::execute($this->transport, $characterId, $page);
    }
    // ...
}
```

These classes are **fully generated** — `bin/generate.php` groups all operations by ESI tag and emits one wrapper class per tag (36 total).

### Rationale
- **Single source of truth** — the per-route statics hold all metadata and call logic. Tag wrappers add zero logic; they are just delegation glue.
- **Transport injected once** — callers that pass `$transport` to many endpoints can hold one `AssetsResource` instance rather than threading `$transport` through every call.
- **esi-client compatibility** — `EsiClient` implements `EsiTransportInterface` and exposes factory methods (`assets()`, `characters()`, etc.) that return these tag wrapper instances.
- **No duplication** — previously both layers called `invoke()` directly. Now only the per-route static does; the tag wrapper is a pure forwarder.

### Alternatives considered
- Removing tag wrappers and updating esi-client to use static calls everywhere — possible, but breaks the fluent API that existing eveapi jobs rely on.
- Generating tag wrappers inside esi-client rather than esi-schema — pushed the responsibility into the wrong package; esi-schema should define the full API surface.

### Consequences
- `src/Resources/` contains both flat `{Tag}Resource.php` files **and** tag subdirectories (`Assets/`, `Character/`, …).
- Tag class namespaces: `Seatplus\EsiSchema\Resources\AssetsResource` (no sub-namespace).
- Per-route class namespaces: `Seatplus\EsiSchema\Resources\Assets\GetCharactersCharacterIdAssets` (tag sub-namespace).
- PSR-4 autoloading handles both correctly.
- Fluent API: `new AssetsResource($transport)->getCharactersCharacterIdAssets($id)` or via esi-client: `$esi->withToken($tok)->assets()->getCharactersCharacterIdAssets($id)`.
