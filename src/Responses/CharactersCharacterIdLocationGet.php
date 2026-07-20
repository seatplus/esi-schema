<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdLocationGet extends AbstractEsiDto
{
    public function __construct(
        public readonly int $solar_system_id,
        public readonly ?int $station_id = null,
        public readonly ?int $structure_id = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            solar_system_id: (int) ($data->solar_system_id ?? 0),
            station_id: $data->station_id ?? null,
            structure_id: $data->structure_id ?? null,
        );
    }
}
