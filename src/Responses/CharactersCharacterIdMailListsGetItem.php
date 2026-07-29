<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdMailListsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $mailing_list_id,
        public readonly string $name,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            mailing_list_id: (int) ($data->mailing_list_id ?? 0),
            name: (string) ($data->name ?? ''),
        );
    }
}
