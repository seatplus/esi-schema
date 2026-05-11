<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsCorporationIdWalletsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly float $balance,
        public readonly int $division,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            balance: (float) ($data->balance ?? 0.0),
            division: (int) ($data->division ?? 0),
        );
    }
}
