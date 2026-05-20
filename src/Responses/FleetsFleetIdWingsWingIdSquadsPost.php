<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FleetsFleetIdWingsWingIdSquadsPost extends AbstractEsiDto
{
    public function __construct(
        public readonly int $squad_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            squad_id: (int) ($data->squad_id ?? 0),
        );
    }
}
