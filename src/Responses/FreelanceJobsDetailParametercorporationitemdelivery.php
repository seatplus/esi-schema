<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FreelanceJobsDetailParametercorporationitemdelivery extends AbstractEsiDto
{
    public function __construct(
        public readonly FreelanceJobsDetailParametermatcher $corporation_office_location,
        public readonly FreelanceJobsDetailParametermatcher $item_type,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            corporation_office_location: FreelanceJobsDetailParametermatcher::from($data->corporation_office_location ?? new \stdClass()),
            item_type: FreelanceJobsDetailParametermatcher::from($data->item_type ?? new \stdClass()),
        );
    }
}
