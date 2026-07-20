<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsDetailResourceworkforce extends AbstractEsiDto
{
    public function __construct(
        public readonly int $allocated,
        public readonly int $available,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            allocated: (int) ($data->allocated ?? 0),
            available: (int) ($data->available ?? 0),
        );
    }
}
