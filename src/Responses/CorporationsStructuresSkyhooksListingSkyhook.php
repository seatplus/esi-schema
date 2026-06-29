<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSkyhooksListingSkyhook extends AbstractEsiDto
{
    public function __construct(
        public readonly int $id,
        public readonly int $planet_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            id: (int) ($data->id ?? 0),
            planet_id: (int) ($data->planet_id ?? 0),
        );
    }
}
