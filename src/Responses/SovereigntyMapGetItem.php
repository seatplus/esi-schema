<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class SovereigntyMapGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $system_id,
        public readonly ?int $alliance_id = null,
        public readonly ?int $corporation_id = null,
        public readonly ?int $faction_id = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            system_id: (int) ($data->system_id ?? 0),
            alliance_id: $data->alliance_id ?? null,
            corporation_id: $data->corporation_id ?? null,
            faction_id: $data->faction_id ?? null,
        );
    }
}
