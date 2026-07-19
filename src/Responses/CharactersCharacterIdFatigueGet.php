<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdFatigueGet extends AbstractEsiDto
{
    public function __construct(
        public readonly ?string $jump_fatigue_expire_date = null,
        public readonly ?string $last_jump_date = null,
        public readonly ?string $last_update_date = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            jump_fatigue_expire_date: $data->jump_fatigue_expire_date ?? null,
            last_jump_date: $data->last_jump_date ?? null,
            last_update_date: $data->last_update_date ?? null,
        );
    }
}
