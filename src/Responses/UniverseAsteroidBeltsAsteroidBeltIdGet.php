<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseAsteroidBeltsAsteroidBeltIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly string $name,
        public readonly mixed $position,
        public readonly int $system_id,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            name: (string) ($data->name ?? ''),
            position: ($data->position ?? null),
            system_id: (int) ($data->system_id ?? 0),
        );
    }
}