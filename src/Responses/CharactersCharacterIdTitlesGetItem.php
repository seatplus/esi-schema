<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdTitlesGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?int $title_id = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            name: $data->name ?? null,
            title_id: $data->title_id ?? null,
        );
    }
}
