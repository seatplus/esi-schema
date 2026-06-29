<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class ContractsPublicItemsContractIdGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly bool $is_included,
        public readonly int $quantity,
        public readonly int $record_id,
        public readonly int $type_id,
        public readonly ?bool $is_blueprint_copy = null,
        public readonly ?int $item_id = null,
        public readonly ?int $material_efficiency = null,
        public readonly ?int $runs = null,
        public readonly ?int $time_efficiency = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            is_included: (bool) ($data->is_included ?? false),
            quantity: (int) ($data->quantity ?? 0),
            record_id: (int) ($data->record_id ?? 0),
            type_id: (int) ($data->type_id ?? 0),
            is_blueprint_copy: $data->is_blueprint_copy ?? null,
            item_id: $data->item_id ?? null,
            material_efficiency: $data->material_efficiency ?? null,
            runs: $data->runs ?? null,
            time_efficiency: $data->time_efficiency ?? null,
        );
    }
}
