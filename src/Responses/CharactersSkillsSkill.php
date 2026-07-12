<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersSkillsSkill extends AbstractEsiDto
{
    public function __construct(
        public readonly int $active_skill_level,
        public readonly int $skill_id,
        public readonly int $skillpoints_in_skill,
        public readonly int $trained_skill_level,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            active_skill_level: (int) ($data->active_skill_level ?? 0),
            skill_id: (int) ($data->skill_id ?? 0),
            skillpoints_in_skill: (int) ($data->skillpoints_in_skill ?? 0),
            trained_skill_level: (int) ($data->trained_skill_level ?? 0),
        );
    }
}
