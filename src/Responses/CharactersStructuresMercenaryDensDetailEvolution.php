<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersStructuresMercenaryDensDetailEvolution extends AbstractEsiDto
{
    public function __construct(
        public readonly CharactersStructuresMercenaryDensDetailEvolutionanarchy $anarchy,
        public readonly CharactersStructuresMercenaryDensDetailEvolutiondevelopment $development,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            anarchy: CharactersStructuresMercenaryDensDetailEvolutionanarchy::from($data->anarchy ?? new \stdClass()),
            development: CharactersStructuresMercenaryDensDetailEvolutiondevelopment::from($data->development ?? new \stdClass()),
        );
    }
}
