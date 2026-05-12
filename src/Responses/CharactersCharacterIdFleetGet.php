<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdFleetGet extends AbstractEsiDto
{
    public function __construct(
        public readonly int $fleet_boss_id,
        public readonly int $fleet_id,
        public readonly string $role,
        public readonly int $squad_id,
        public readonly int $wing_id,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            fleet_boss_id: (int) ($data->fleet_boss_id ?? 0),
            fleet_id: (int) ($data->fleet_id ?? 0),
            role: (string) ($data->role ?? ''),
            squad_id: (int) ($data->squad_id ?? 0),
            wing_id: (int) ($data->wing_id ?? 0),
        );
    }
}