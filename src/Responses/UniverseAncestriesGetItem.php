<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseAncestriesGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $bloodline_id,
        public readonly string $description,
        public readonly int $id,
        public readonly string $name,
        public readonly ?int $icon_id = null,
        public readonly ?string $short_description = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            bloodline_id: (int) ($data->bloodline_id ?? 0),
            description: (string) ($data->description ?? ''),
            id: (int) ($data->id ?? 0),
            name: (string) ($data->name ?? ''),
            icon_id: $data->icon_id ?? null,
            short_description: $data->short_description ?? null,
        );
    }
}
