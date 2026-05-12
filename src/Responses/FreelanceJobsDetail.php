<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FreelanceJobsDetail extends AbstractEsiDto
{
    public function __construct(
        public readonly FreelanceJobsDetailAccessandvisibility $access_and_visibility,
        public readonly FreelanceJobsDetailConfiguration $configuration,
        public readonly FreelanceJobsDetailDetails $details,
        public readonly string $id,
        public readonly string $last_modified,
        public readonly string $name,
        public readonly FreelanceJobsDetailProgress $progress,
        public readonly string $state,
        public readonly ?FreelanceJobsDetailContribution $contribution = null,
        public readonly ?FreelanceJobsDetailReward $reward = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            access_and_visibility: FreelanceJobsDetailAccessandvisibility::from($data->access_and_visibility ?? new \stdClass()),
            configuration: FreelanceJobsDetailConfiguration::from($data->configuration ?? new \stdClass()),
            details: FreelanceJobsDetailDetails::from($data->details ?? new \stdClass()),
            id: (string) ($data->id ?? ''),
            last_modified: (string) ($data->last_modified ?? ''),
            name: (string) ($data->name ?? ''),
            progress: FreelanceJobsDetailProgress::from($data->progress ?? new \stdClass()),
            state: (string) ($data->state ?? ''),
            contribution: isset($data->contribution) ? FreelanceJobsDetailContribution::from($data->contribution) : null,
            reward: isset($data->reward) ? FreelanceJobsDetailReward::from($data->reward) : null,
        );
    }
}
