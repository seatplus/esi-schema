<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

use Seatplus\EsiSchema\Responses\FreelanceJobsDetailCreator;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FreelanceJobsDetailDetails extends AbstractEsiDto
{
    public function __construct(
        public readonly string $career,
        public readonly string $created,
        public readonly FreelanceJobsDetailCreator $creator,
        public readonly string $description,
        public readonly ?string $expires = null,
        public readonly ?string $finished = null,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            career: (string) ($data->career ?? ''),
            created: (string) ($data->created ?? ''),
            creator: FreelanceJobsDetailCreator::from($data->creator ?? new \stdClass()),
            description: (string) ($data->description ?? ''),
            expires: $data->expires ?? null,
            finished: $data->finished ?? null,
        );
    }
}