<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class DogmaDynamicItemsTypeIdItemIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly int $created_by,
        public readonly array $dogma_attributes,
        public readonly array $dogma_effects,
        public readonly int $mutator_type_id,
        public readonly int $source_type_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            created_by: (int) ($data->created_by ?? 0),
            dogma_attributes: (array) ($data->dogma_attributes ?? []),
            dogma_effects: (array) ($data->dogma_effects ?? []),
            mutator_type_id: (int) ($data->mutator_type_id ?? 0),
            source_type_id: (int) ($data->source_type_id ?? 0),
        );
    }
}
