<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FreelanceJobsDetailFreelancejob extends AbstractEsiDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $last_modified,
        public readonly string $name,
        public readonly FreelanceJobsDetailProgress $progress,
        public readonly string $state,
        public readonly ?FreelanceJobsDetailReward $reward = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            id: (string) ($data->id ?? ''),
            last_modified: (string) ($data->last_modified ?? ''),
            name: (string) ($data->name ?? ''),
            progress: FreelanceJobsDetailProgress::from($data->progress ?? new \stdClass()),
            state: (string) ($data->state ?? ''),
            reward: isset($data->reward) ? FreelanceJobsDetailReward::from($data->reward) : null,
        );
    }
}
