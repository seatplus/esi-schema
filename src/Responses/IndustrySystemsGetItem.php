<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class IndustrySystemsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly array $cost_indices,
        public readonly int $solar_system_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            cost_indices: (array) ($data->cost_indices ?? []),
            solar_system_id: (int) ($data->solar_system_id ?? 0),
        );
    }
}
