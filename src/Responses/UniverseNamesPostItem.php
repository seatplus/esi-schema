<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseNamesPostItem extends AbstractEsiDto
{
    public function __construct(
        public readonly string $category,
        public readonly int $id,
        public readonly string $name,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            category: (string) ($data->category ?? ''),
            id: (int) ($data->id ?? 0),
            name: (string) ($data->name ?? ''),
        );
    }
}