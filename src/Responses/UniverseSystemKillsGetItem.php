<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseSystemKillsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $npc_kills,
        public readonly int $pod_kills,
        public readonly int $ship_kills,
        public readonly int $system_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            npc_kills: (int) ($data->npc_kills ?? 0),
            pod_kills: (int) ($data->pod_kills ?? 0),
            ship_kills: (int) ($data->ship_kills ?? 0),
            system_id: (int) ($data->system_id ?? 0),
        );
    }
}
