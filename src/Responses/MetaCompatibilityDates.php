<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class MetaCompatibilityDates extends AbstractEsiDto
{
    public function __construct(
        public readonly array $compatibility_dates,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            compatibility_dates: (array) ($data->compatibility_dates ?? []),
        );
    }
}