<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseRegionsRegionIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly array $constellations,
        public readonly string $name,
        public readonly int $region_id,
        public readonly ?string $description = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            constellations: (array) ($data->constellations ?? []),
            name: (string) ($data->name ?? ''),
            region_id: (int) ($data->region_id ?? 0),
            description: $data->description ?? null,
        );
    }
}
