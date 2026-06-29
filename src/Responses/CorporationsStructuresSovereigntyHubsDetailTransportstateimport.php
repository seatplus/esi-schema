<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsDetailTransportstateimport extends AbstractEsiDto
{
    public function __construct(
        public readonly array $sources,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            sources: array_map(fn (object $i) => CorporationsStructuresSovereigntyHubsDetailTransportstateimportsource::from($i), (array) ($data->sources ?? [])),
        );
    }
}
