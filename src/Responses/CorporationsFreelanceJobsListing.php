<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsFreelanceJobsListing extends AbstractEsiDto
{
    public function __construct(
        public readonly array $freelance_jobs,
        public readonly ?Cursor $cursor = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            freelance_jobs: array_map(fn (object $i) => FreelanceJobsDetailFreelancejob::from($i), (array) ($data->freelance_jobs ?? [])),
            cursor: isset($data->cursor) ? Cursor::from($data->cursor) : null,
        );
    }
}
