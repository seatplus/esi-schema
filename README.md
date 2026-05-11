# seatplus/esi-schema

**Pure DTO library** for the EVE Online ESI API. Zero runtime dependencies.

Every response schema from the ESI OpenAPI spec (compatibility date `2025-12-16`) is represented as a typed PHP class with `readonly` properties and a `::from(object $data)` factory method.

## Requirements

- PHP 8.5+

## Installation

```bash
composer require seatplus/esi-schema
```

## Usage

DTOs are located in `Seatplus\EsiSchema\Responses\` and all extend `AbstractEsiDto`.

```php
use Seatplus\EsiSchema\Responses\AllianceDetail;

// Construct from raw ESI response data
$alliance = AllianceDetail::from($esiResponseBody);

echo $alliance->name;        // typed readonly string
echo $alliance->ticker;      // typed readonly string

// HTTP metadata (set by the SDK/transport layer)
$alliance->isCachedLoad;    // bool — was this response served from cache?
$alliance->pages;            // int — X-Pages header value (1 for single-object endpoints)
```

### With esi-client (SDK layer)

The [seatplus/esi-client](https://github.com/seatplus/esi-client) package uses these DTOs as return types from its resource methods:

```php
$alliance = $sdk->alliance()->getAlliancesAllianceId(99000006);
// $alliance is AllianceDetail — not wrapped in any EsiResult
echo $alliance->name;
$alliance->isCachedLoad; // true if response came from HTTP cache
```

## Design

- **Zero runtime dependencies** — only PHP 8.5+ is required.
- **Defensive `from()` methods** — all fields use `?? <default>` fallbacks to survive CCP stealth field changes (fields removed without bumping the compatibility date).
- **`AbstractEsiDto` base class** — carries `$isCachedLoad` and `$pages` as mutable properties. These are intentionally not `readonly` so the transport layer can set them after calling `::from()`.
- **`final` DTOs** — all response classes are `final` and are not intended to be subclassed.
- **Versioned by compatibility date** — this package tracks ESI compatibility date `2025-12-16`. A future `2.x` would track a newer date.

## Regenerating DTOs

To regenerate from a new ESI OpenAPI spec:

```bash
php bin/generate.php
vendor/bin/pint  # auto-format generated output
```

The generator reads `resources/openapi.yaml` (fetched from `https://esi.evetech.net/meta/openapi.yaml?compatibility_date=2025-12-16`).

## Testing

```bash
composer test          # lint + types + unit
composer test:unit     # Pest tests only
composer test:types    # PHPStan analysis
composer lint          # Pint auto-format
```
