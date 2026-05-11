<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsCorporationIdMembertrackingGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $character_id,
        public readonly ?int $base_id = null,
        public readonly ?int $location_id = null,
        public readonly ?string $logoff_date = null,
        public readonly ?string $logon_date = null,
        public readonly ?int $ship_type_id = null,
        public readonly ?string $start_date = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            character_id: (int) ($data->character_id ?? 0),
            base_id: $data->base_id ?? null,
            location_id: $data->location_id ?? null,
            logoff_date: $data->logoff_date ?? null,
            logon_date: $data->logon_date ?? null,
            ship_type_id: $data->ship_type_id ?? null,
            start_date: $data->start_date ?? null,
        );
    }
}
