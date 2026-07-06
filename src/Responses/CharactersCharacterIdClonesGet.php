<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdClonesGet extends AbstractEsiDto
{
    public function __construct(
        public readonly array $jump_clones,
        public readonly mixed $home_location = null,
        public readonly ?string $last_clone_jump_date = null,
        public readonly ?string $last_station_change_date = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            jump_clones: (array) ($data->jump_clones ?? []),
            home_location: $data->home_location ?? null,
            last_clone_jump_date: $data->last_clone_jump_date ?? null,
            last_station_change_date: $data->last_station_change_date ?? null,
        );
    }
}
