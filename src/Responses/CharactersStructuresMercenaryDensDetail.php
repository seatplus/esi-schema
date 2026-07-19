<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersStructuresMercenaryDensDetail extends AbstractEsiDto
{
    public function __construct(
        public readonly CharactersStructuresMercenaryDensDetailEvolution $evolution,
        public readonly int $id,
        public readonly CharactersStructuresMercenaryDensDetailInfomorphs $infomorphs,
        public readonly CharactersStructuresMercenaryDensDetailSkyhook $skyhook,
        public readonly string $state,
        public readonly int $type_id,
        public readonly ?CharactersStructuresMercenaryDensDetailReinforcementtimer $reinforcement_timer = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            evolution: CharactersStructuresMercenaryDensDetailEvolution::from($data->evolution ?? new \stdClass()),
            id: (int) ($data->id ?? 0),
            infomorphs: CharactersStructuresMercenaryDensDetailInfomorphs::from($data->infomorphs ?? new \stdClass()),
            skyhook: CharactersStructuresMercenaryDensDetailSkyhook::from($data->skyhook ?? new \stdClass()),
            state: (string) ($data->state ?? ''),
            type_id: (int) ($data->type_id ?? 0),
            reinforcement_timer: isset($data->reinforcement_timer) ? CharactersStructuresMercenaryDensDetailReinforcementtimer::from($data->reinforcement_timer) : null,
        );
    }
}
