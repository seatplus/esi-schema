<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersFreelanceJobsParticipation extends AbstractEsiDto
{
    public function __construct(
        public readonly int $contributed,
        public readonly string $last_modified,
        public readonly string $state,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            contributed: (int) ($data->contributed ?? 0),
            last_modified: (string) ($data->last_modified ?? ''),
            state: (string) ($data->state ?? ''),
        );
    }
}
