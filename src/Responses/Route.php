<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class Route extends AbstractEsiDto
{
    public function __construct(
        public readonly array $route,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            route: (array) ($data->route ?? []),
        );
    }
}
