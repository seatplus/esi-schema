<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FreelanceJobsDetailAccessandvisibility extends AbstractEsiDto
{
    public function __construct(
        public readonly bool $acl_protected,
        public readonly ?array $broadcast_locations = null,
        public readonly ?FreelanceJobsDetailRestrictions $restrictions = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            acl_protected: (bool) ($data->acl_protected ?? false),
            broadcast_locations: isset($data->broadcast_locations) ? (array) $data->broadcast_locations : null,
            restrictions: isset($data->restrictions) ? FreelanceJobsDetailRestrictions::from($data->restrictions) : null,
        );
    }
}
