<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersStructuresMercenaryDensDetailSkyhook extends AbstractEsiDto
{
    public function __construct(
        public readonly int $corporation_id,
        public readonly int $id,
        public readonly int $planet_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            corporation_id: (int) ($data->corporation_id ?? 0),
            id: (int) ($data->id ?? 0),
            planet_id: (int) ($data->planet_id ?? 0),
        );
    }
}
