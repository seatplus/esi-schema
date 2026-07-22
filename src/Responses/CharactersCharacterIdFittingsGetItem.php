<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdFittingsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly string $description,
        public readonly int $fitting_id,
        public readonly array $items,
        public readonly string $name,
        public readonly int $ship_type_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            description: (string) ($data->description ?? ''),
            fitting_id: (int) ($data->fitting_id ?? 0),
            items: (array) ($data->items ?? []),
            name: (string) ($data->name ?? ''),
            ship_type_id: (int) ($data->ship_type_id ?? 0),
        );
    }
}
