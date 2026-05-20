<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdOrdersGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $duration,
        public readonly bool $is_corporation,
        public readonly string $issued,
        public readonly int $location_id,
        public readonly int $order_id,
        public readonly float $price,
        public readonly string $range,
        public readonly int $region_id,
        public readonly int $type_id,
        public readonly int $volume_remain,
        public readonly int $volume_total,
        public readonly ?float $escrow = null,
        public readonly ?bool $is_buy_order = null,
        public readonly ?int $min_volume = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            duration: (int) ($data->duration ?? 0),
            is_corporation: (bool) ($data->is_corporation ?? false),
            issued: (string) ($data->issued ?? ''),
            location_id: (int) ($data->location_id ?? 0),
            order_id: (int) ($data->order_id ?? 0),
            price: (float) ($data->price ?? 0.0),
            range: (string) ($data->range ?? ''),
            region_id: (int) ($data->region_id ?? 0),
            type_id: (int) ($data->type_id ?? 0),
            volume_remain: (int) ($data->volume_remain ?? 0),
            volume_total: (int) ($data->volume_total ?? 0),
            escrow: $data->escrow ?? null,
            is_buy_order: $data->is_buy_order ?? null,
            min_volume: $data->min_volume ?? null,
        );
    }
}
