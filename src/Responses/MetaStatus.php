<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class MetaStatus extends AbstractEsiDto
{
    public function __construct(
        public readonly array $routes,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            routes: array_map(fn (object $i) => MetaStatusRoutestatus::from($i), (array) ($data->routes ?? [])),
        );
    }
}
