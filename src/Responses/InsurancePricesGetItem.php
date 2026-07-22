<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class InsurancePricesGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly array $levels,
        public readonly int $type_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            levels: (array) ($data->levels ?? []),
            type_id: (int) ($data->type_id ?? 0),
        );
    }
}
