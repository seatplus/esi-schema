<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsDetailTransportstateexport extends AbstractEsiDto
{
    public function __construct(
        public readonly ?int $amount = null,
        public readonly ?int $solar_system_id = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            amount: $data->amount ?? null,
            solar_system_id: $data->solar_system_id ?? null,
        );
    }
}
