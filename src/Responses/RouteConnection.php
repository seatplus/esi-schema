<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class RouteConnection extends AbstractEsiDto
{
    public function __construct(
        public readonly int $from,
        public readonly int $to,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            from: (int) ($data->from ?? 0),
            to: (int) ($data->to ?? 0),
        );
    }
}