<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class MarketsPricesGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $type_id,
        public readonly ?float $adjusted_price = null,
        public readonly ?float $average_price = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            type_id: (int) ($data->type_id ?? 0),
            adjusted_price: $data->adjusted_price ?? null,
            average_price: $data->average_price ?? null,
        );
    }
}
