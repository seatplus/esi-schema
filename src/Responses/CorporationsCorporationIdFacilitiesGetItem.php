<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsCorporationIdFacilitiesGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $facility_id,
        public readonly int $system_id,
        public readonly int $type_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            facility_id: (int) ($data->facility_id ?? 0),
            system_id: (int) ($data->system_id ?? 0),
            type_id: (int) ($data->type_id ?? 0),
        );
    }
}
