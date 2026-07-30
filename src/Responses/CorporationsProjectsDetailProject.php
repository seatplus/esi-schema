<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailProject extends AbstractEsiDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $last_modified,
        public readonly string $name,
        public readonly CorporationsProjectsDetailProgress $progress,
        public readonly string $state,
        public readonly ?CorporationsProjectsDetailReward $reward = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            id: (string) ($data->id ?? ''),
            last_modified: (string) ($data->last_modified ?? ''),
            name: (string) ($data->name ?? ''),
            progress: CorporationsProjectsDetailProgress::from($data->progress ?? new \stdClass()),
            state: (string) ($data->state ?? ''),
            reward: isset($data->reward) ? CorporationsProjectsDetailReward::from($data->reward) : null,
        );
    }
}
