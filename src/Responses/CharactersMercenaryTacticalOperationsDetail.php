<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersMercenaryTacticalOperationsDetail extends AbstractEsiDto
{
    public function __construct(
        public readonly int $dungeon_type_id,
        public readonly string $expires,
        public readonly string $id,
        public readonly int $mercenary_den_id,
        public readonly string $state,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            dungeon_type_id: (int) ($data->dungeon_type_id ?? 0),
            expires: (string) ($data->expires ?? ''),
            id: (string) ($data->id ?? ''),
            mercenary_den_id: (int) ($data->mercenary_den_id ?? 0),
            state: (string) ($data->state ?? ''),
        );
    }
}
