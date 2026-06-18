<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsCorporationIdDivisionsGet extends AbstractEsiDto
{
    public function __construct(
        public readonly ?array $hangar = null,
        public readonly ?array $wallet = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            hangar: isset($data->hangar) ? (array) $data->hangar : null,
            wallet: isset($data->wallet) ? (array) $data->wallet : null,
        );
    }
}
