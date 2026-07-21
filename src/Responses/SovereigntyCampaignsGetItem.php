<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class SovereigntyCampaignsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $campaign_id,
        public readonly int $constellation_id,
        public readonly string $event_type,
        public readonly int $solar_system_id,
        public readonly string $start_time,
        public readonly int $structure_id,
        public readonly ?float $attackers_score = null,
        public readonly ?int $defender_id = null,
        public readonly ?float $defender_score = null,
        public readonly ?array $participants = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            campaign_id: (int) ($data->campaign_id ?? 0),
            constellation_id: (int) ($data->constellation_id ?? 0),
            event_type: (string) ($data->event_type ?? ''),
            solar_system_id: (int) ($data->solar_system_id ?? 0),
            start_time: (string) ($data->start_time ?? ''),
            structure_id: (int) ($data->structure_id ?? 0),
            attackers_score: $data->attackers_score ?? null,
            defender_id: $data->defender_id ?? null,
            defender_score: $data->defender_score ?? null,
            participants: isset($data->participants) ? (array) $data->participants : null,
        );
    }
}
