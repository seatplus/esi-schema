<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationCorporationIdMiningExtractionsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly string $chunk_arrival_time,
        public readonly string $extraction_start_time,
        public readonly int $moon_id,
        public readonly string $natural_decay_time,
        public readonly int $structure_id,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            chunk_arrival_time: (string) ($data->chunk_arrival_time ?? ''),
            extraction_start_time: (string) ($data->extraction_start_time ?? ''),
            moon_id: (int) ($data->moon_id ?? 0),
            natural_decay_time: (string) ($data->natural_decay_time ?? ''),
            structure_id: (int) ($data->structure_id ?? 0),
        );
    }
}