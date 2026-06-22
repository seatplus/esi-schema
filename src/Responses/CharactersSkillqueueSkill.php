<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersSkillqueueSkill extends AbstractEsiDto
{
    public function __construct(
        public readonly int $finished_level,
        public readonly int $queue_position,
        public readonly int $skill_id,
        public readonly ?string $finish_date = null,
        public readonly ?int $level_end_sp = null,
        public readonly ?int $level_start_sp = null,
        public readonly ?string $start_date = null,
        public readonly ?int $training_start_sp = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            finished_level: (int) ($data->finished_level ?? 0),
            queue_position: (int) ($data->queue_position ?? 0),
            skill_id: (int) ($data->skill_id ?? 0),
            finish_date: $data->finish_date ?? null,
            level_end_sp: $data->level_end_sp ?? null,
            level_start_sp: $data->level_start_sp ?? null,
            start_date: $data->start_date ?? null,
            training_start_sp: $data->training_start_sp ?? null,
        );
    }
}
