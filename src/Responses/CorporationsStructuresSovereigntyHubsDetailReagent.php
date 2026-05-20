<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsDetailReagent extends AbstractEsiDto
{
    public function __construct(
        public readonly int $amount,
        public readonly int $burning_per_hour,
        public readonly int $type_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            amount: (int) ($data->amount ?? 0),
            burning_per_hour: (int) ($data->burning_per_hour ?? 0),
            type_id: (int) ($data->type_id ?? 0),
        );
    }
}
