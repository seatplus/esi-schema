<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsDetailTransportconfigurationsource extends AbstractEsiDto
{
    public function __construct(
        public readonly int $solar_system_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            solar_system_id: (int) ($data->solar_system_id ?? 0),
        );
    }
}
