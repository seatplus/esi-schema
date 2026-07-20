<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsCorporationIdIconsGet extends AbstractEsiDto
{
    public function __construct(
        public readonly ?string $px128x128 = null,
        public readonly ?string $px256x256 = null,
        public readonly ?string $px64x64 = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            px128x128: $data->px128x128 ?? null,
            px256x256: $data->px256x256 ?? null,
            px64x64: $data->px64x64 ?? null,
        );
    }
}
