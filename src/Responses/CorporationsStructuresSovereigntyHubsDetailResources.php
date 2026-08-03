<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsDetailResources extends AbstractEsiDto
{
    public function __construct(
        public readonly CorporationsStructuresSovereigntyHubsDetailResourcepower $power,
        public readonly CorporationsStructuresSovereigntyHubsDetailResourceworkforce $workforce,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            power: CorporationsStructuresSovereigntyHubsDetailResourcepower::from($data->power ?? new \stdClass()),
            workforce: CorporationsStructuresSovereigntyHubsDetailResourceworkforce::from($data->workforce ?? new \stdClass()),
        );
    }
}
