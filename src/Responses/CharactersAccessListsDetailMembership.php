<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersAccessListsDetailMembership extends AbstractEsiDto
{
    public function __construct(
        public readonly array $alliances,
        public readonly bool $allow_everyone,
        public readonly array $characters,
        public readonly array $corporations,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            alliances: array_map(fn (object $i) => CharactersAccessListsDetailAllianceentry::from($i), (array) ($data->alliances ?? [])),
            allow_everyone: (bool) ($data->allow_everyone ?? false),
            characters: array_map(fn (object $i) => CharactersAccessListsDetailCharacterentry::from($i), (array) ($data->characters ?? [])),
            corporations: array_map(fn (object $i) => CharactersAccessListsDetailCorporationentry::from($i), (array) ($data->corporations ?? [])),
        );
    }
}
