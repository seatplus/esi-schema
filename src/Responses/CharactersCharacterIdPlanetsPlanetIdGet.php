<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdPlanetsPlanetIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly array $links,
        public readonly array $pins,
        public readonly array $routes,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            links: (array) ($data->links ?? []),
            pins: (array) ($data->pins ?? []),
            routes: (array) ($data->routes ?? []),
        );
    }
}
