<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSkyhooksDetail extends AbstractEsiDto
{
    public function __construct(
        public readonly int $id,
        public readonly bool $is_active,
        public readonly int $planet_id,
        public readonly string $state,
        public readonly ?int $effective_workforce = null,
        public readonly ?array $reagents = null,
        public readonly ?CorporationsStructuresSkyhooksDetailReinforcementtimer $reinforcement_timer = null,
        public readonly ?CorporationsStructuresSkyhooksDetailTheftvulnerability $theft_vulnerability = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            id: (int) ($data->id ?? 0),
            is_active: (bool) ($data->is_active ?? false),
            planet_id: (int) ($data->planet_id ?? 0),
            state: (string) ($data->state ?? ''),
            effective_workforce: $data->effective_workforce ?? null,
            reagents: isset($data->reagents) ? (array) $data->reagents : null,
            reinforcement_timer: isset($data->reinforcement_timer) ? CorporationsStructuresSkyhooksDetailReinforcementtimer::from($data->reinforcement_timer) : null,
            theft_vulnerability: isset($data->theft_vulnerability) ? CorporationsStructuresSkyhooksDetailTheftvulnerability::from($data->theft_vulnerability) : null,
        );
    }
}
