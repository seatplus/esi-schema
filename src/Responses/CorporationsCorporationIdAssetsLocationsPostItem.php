<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsCorporationIdAssetsLocationsPostItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $item_id,
        public readonly mixed $position,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            item_id: (int) ($data->item_id ?? 0),
            position: ($data->position ?? null),
        );
    }
}