<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FreelanceJobsDetailContribution extends AbstractEsiDto
{
    public function __construct(
        public readonly int $max_committed_participants,
        public readonly ?int $contribution_per_participant_limit = null,
        public readonly ?float $reward_per_contribution = null,
        public readonly ?int $submission_limit = null,
        public readonly ?float $submission_multiplier = null,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            max_committed_participants: (int) ($data->max_committed_participants ?? 0),
            contribution_per_participant_limit: $data->contribution_per_participant_limit ?? null,
            reward_per_contribution: $data->reward_per_contribution ?? null,
            submission_limit: $data->submission_limit ?? null,
            submission_multiplier: $data->submission_multiplier ?? null,
        );
    }
}