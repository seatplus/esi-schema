<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdAssetsNamesPostItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $item_id,
        public readonly string $name,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            item_id: (int) ($data->item_id ?? 0),
            name: (string) ($data->name ?? ''),
        );
    }
}
