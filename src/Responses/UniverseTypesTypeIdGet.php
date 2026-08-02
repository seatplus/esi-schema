<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseTypesTypeIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly string $description,
        public readonly int $group_id,
        public readonly string $name,
        public readonly bool $published,
        public readonly int $type_id,
        public readonly ?float $capacity = null,
        public readonly ?array $dogma_attributes = null,
        public readonly ?array $dogma_effects = null,
        public readonly ?int $graphic_id = null,
        public readonly ?int $icon_id = null,
        public readonly ?int $market_group_id = null,
        public readonly ?float $mass = null,
        public readonly ?float $packaged_volume = null,
        public readonly ?int $portion_size = null,
        public readonly ?float $radius = null,
        public readonly ?float $volume = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            description: (string) ($data->description ?? ''),
            group_id: (int) ($data->group_id ?? 0),
            name: (string) ($data->name ?? ''),
            published: (bool) ($data->published ?? false),
            type_id: (int) ($data->type_id ?? 0),
            capacity: $data->capacity ?? null,
            dogma_attributes: isset($data->dogma_attributes) ? (array) $data->dogma_attributes : null,
            dogma_effects: isset($data->dogma_effects) ? (array) $data->dogma_effects : null,
            graphic_id: $data->graphic_id ?? null,
            icon_id: $data->icon_id ?? null,
            market_group_id: $data->market_group_id ?? null,
            mass: $data->mass ?? null,
            packaged_volume: $data->packaged_volume ?? null,
            portion_size: $data->portion_size ?? null,
            radius: $data->radius ?? null,
            volume: $data->volume ?? null,
        );
    }
}
