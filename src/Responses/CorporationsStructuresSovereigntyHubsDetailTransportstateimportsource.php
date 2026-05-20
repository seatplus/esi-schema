<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsDetailTransportstateimportsource extends AbstractEsiDto
{
    public function __construct(
        public readonly int $amount,
        public readonly int $solar_system_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            amount: (int) ($data->amount ?? 0),
            solar_system_id: (int) ($data->solar_system_id ?? 0),
        );
    }
}
