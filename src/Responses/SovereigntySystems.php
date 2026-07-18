<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class SovereigntySystems extends AbstractEsiDto
{
    public function __construct(
        public readonly array $solar_systems,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            solar_systems: array_map(fn (object $i) => SovereigntySystemsSolarsystem::from($i), (array) ($data->solar_systems ?? [])),
        );
    }
}
