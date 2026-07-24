<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailReward extends AbstractEsiDto
{
    public function __construct(
        public readonly float $initial,
        public readonly float $remaining,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            initial: (float) ($data->initial ?? 0.0),
            remaining: (float) ($data->remaining ?? 0.0),
        );
    }
}
