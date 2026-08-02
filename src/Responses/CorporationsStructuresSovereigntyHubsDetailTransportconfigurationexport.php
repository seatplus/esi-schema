<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsDetailTransportconfigurationexport extends AbstractEsiDto
{
    public function __construct(
        public readonly int $amount,
        public readonly ?int $solar_system_id = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            amount: (int) ($data->amount ?? 0),
            solar_system_id: $data->solar_system_id ?? null,
        );
    }
}
