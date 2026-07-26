<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class SkyhooksRaidableVulnerableskyhook extends AbstractEsiDto
{
    public function __construct(
        public readonly int $planet_id,
        public readonly int $solar_system_id,
        public readonly SkyhooksRaidableTheftvulnerability $theft_vulnerability,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            planet_id: (int) ($data->planet_id ?? 0),
            solar_system_id: (int) ($data->solar_system_id ?? 0),
            theft_vulnerability: SkyhooksRaidableTheftvulnerability::from($data->theft_vulnerability ?? new \stdClass()),
        );
    }
}
