<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class AlliancesAllianceIdIconsGet extends AbstractEsiDto
{
    public function __construct(
        public readonly ?string $px128x128 = null,
        public readonly ?string $px64x64 = null,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            px128x128: $data->px128x128 ?? null,
            px64x64: $data->px64x64 ?? null,
        );
    }
}