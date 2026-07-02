<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseStarsStarIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly int $age,
        public readonly float $luminosity,
        public readonly string $name,
        public readonly int $radius,
        public readonly int $solar_system_id,
        public readonly string $spectral_class,
        public readonly int $temperature,
        public readonly int $type_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            age: (int) ($data->age ?? 0),
            luminosity: (float) ($data->luminosity ?? 0.0),
            name: (string) ($data->name ?? ''),
            radius: (int) ($data->radius ?? 0),
            solar_system_id: (int) ($data->solar_system_id ?? 0),
            spectral_class: (string) ($data->spectral_class ?? ''),
            temperature: (int) ($data->temperature ?? 0),
            type_id: (int) ($data->type_id ?? 0),
        );
    }
}
