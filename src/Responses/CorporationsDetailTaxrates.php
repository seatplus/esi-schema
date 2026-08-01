<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsDetailTaxrates extends AbstractEsiDto
{
    public function __construct(
        public readonly float $isk,
        public readonly float $loyalty_point,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            isk: (float) ($data->isk ?? 0.0),
            loyalty_point: (float) ($data->loyalty_point ?? 0.0),
        );
    }
}
