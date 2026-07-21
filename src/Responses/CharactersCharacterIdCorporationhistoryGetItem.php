<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdCorporationhistoryGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $corporation_id,
        public readonly int $record_id,
        public readonly string $start_date,
        public readonly ?bool $is_deleted = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            corporation_id: (int) ($data->corporation_id ?? 0),
            record_id: (int) ($data->record_id ?? 0),
            start_date: (string) ($data->start_date ?? ''),
            is_deleted: $data->is_deleted ?? null,
        );
    }
}
