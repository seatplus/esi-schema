<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersSkills extends AbstractEsiDto
{
    public function __construct(
        public readonly array $skills,
        public readonly int $total_sp,
        public readonly ?int $unallocated_sp = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            skills: array_map(fn (object $i) => CharactersSkillsSkill::from($i), (array) ($data->skills ?? [])),
            total_sp: (int) ($data->total_sp ?? 0),
            unallocated_sp: $data->unallocated_sp ?? null,
        );
    }
}
