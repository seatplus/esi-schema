<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseMoonsMoonIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly int $moon_id,
        public readonly string $name,
        public readonly mixed $position,
        public readonly int $system_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            moon_id: (int) ($data->moon_id ?? 0),
            name: (string) ($data->name ?? ''),
            position: ($data->position ?? null),
            system_id: (int) ($data->system_id ?? 0),
        );
    }
}
