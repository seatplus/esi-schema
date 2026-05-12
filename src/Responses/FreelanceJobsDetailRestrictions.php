<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FreelanceJobsDetailRestrictions extends AbstractEsiDto
{
    public function __construct(
        public readonly ?int $maximum_age = null,
        public readonly ?int $minimum_age = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            maximum_age: $data->maximum_age ?? null,
            minimum_age: $data->minimum_age ?? null,
        );
    }
}
