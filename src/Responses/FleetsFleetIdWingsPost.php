<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FleetsFleetIdWingsPost extends AbstractEsiDto
{
    public function __construct(
        public readonly int $wing_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            wing_id: (int) ($data->wing_id ?? 0),
        );
    }
}
