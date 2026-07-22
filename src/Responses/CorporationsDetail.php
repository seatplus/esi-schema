<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsDetail extends AbstractEsiDto
{
    public function __construct(
        public readonly string $description,
        public readonly string $friendly_fire,
        public readonly int $home_station_id,
        public readonly int $member_count,
        public readonly string $name,
        public readonly int $shares,
        public readonly string $state,
        public readonly CorporationsDetailTaxrates $tax_rates,
        public readonly string $ticker,
        public readonly string $type,
        public readonly bool $war_eligible,
        public readonly ?int $alliance_id = null,
        public readonly ?int $ceo_id = null,
        public readonly ?int $creator_id = null,
        public readonly ?string $date_founded = null,
        public readonly ?int $enlisted_faction_id = null,
        public readonly ?CorporationsDetailPalette $palette = null,
        public readonly ?string $url = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            description: (string) ($data->description ?? ''),
            friendly_fire: (string) ($data->friendly_fire ?? ''),
            home_station_id: (int) ($data->home_station_id ?? 0),
            member_count: (int) ($data->member_count ?? 0),
            name: (string) ($data->name ?? ''),
            shares: (int) ($data->shares ?? 0),
            state: (string) ($data->state ?? ''),
            tax_rates: CorporationsDetailTaxrates::from($data->tax_rates ?? new \stdClass()),
            ticker: (string) ($data->ticker ?? ''),
            type: (string) ($data->type ?? ''),
            war_eligible: (bool) ($data->war_eligible ?? false),
            alliance_id: $data->alliance_id ?? null,
            ceo_id: $data->ceo_id ?? null,
            creator_id: $data->creator_id ?? null,
            date_founded: $data->date_founded ?? null,
            enlisted_faction_id: $data->enlisted_faction_id ?? null,
            palette: isset($data->palette) ? CorporationsDetailPalette::from($data->palette) : null,
            url: $data->url ?? null,
        );
    }
}
