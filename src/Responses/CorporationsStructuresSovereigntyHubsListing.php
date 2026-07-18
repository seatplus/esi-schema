<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsListing extends AbstractEsiDto
{
    public function __construct(
        public readonly array $sovereignty_hubs,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            sovereignty_hubs: array_map(fn (object $i) => CorporationsStructuresSovereigntyHubsListingSovereigntyhub::from($i), (array) ($data->sovereignty_hubs ?? [])),
        );
    }
}
