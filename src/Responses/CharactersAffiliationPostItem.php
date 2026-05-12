<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersAffiliationPostItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $character_id,
        public readonly int $corporation_id,
        public readonly ?int $alliance_id = null,
        public readonly ?int $faction_id = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            character_id: (int) ($data->character_id ?? 0),
            corporation_id: (int) ($data->corporation_id ?? 0),
            alliance_id: $data->alliance_id ?? null,
            faction_id: $data->faction_id ?? null,
        );
    }
}
