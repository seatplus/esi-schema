<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniversePlanetsPlanetIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly string $name,
        public readonly int $planet_id,
        public readonly mixed $position,
        public readonly int $system_id,
        public readonly int $type_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            name: (string) ($data->name ?? ''),
            planet_id: (int) ($data->planet_id ?? 0),
            position: ($data->position ?? null),
            system_id: (int) ($data->system_id ?? 0),
            type_id: (int) ($data->type_id ?? 0),
        );
    }
}
