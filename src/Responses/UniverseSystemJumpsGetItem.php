<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseSystemJumpsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $ship_jumps,
        public readonly int $system_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            ship_jumps: (int) ($data->ship_jumps ?? 0),
            system_id: (int) ($data->system_id ?? 0),
        );
    }
}
