<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdMiningGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly string $date,
        public readonly int $quantity,
        public readonly int $solar_system_id,
        public readonly int $type_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            date: (string) ($data->date ?? ''),
            quantity: (int) ($data->quantity ?? 0),
            solar_system_id: (int) ($data->solar_system_id ?? 0),
            type_id: (int) ($data->type_id ?? 0),
        );
    }
}
