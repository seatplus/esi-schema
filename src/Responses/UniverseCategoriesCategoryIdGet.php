<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseCategoriesCategoryIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly int $category_id,
        public readonly array $groups,
        public readonly string $name,
        public readonly bool $published,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            category_id: (int) ($data->category_id ?? 0),
            groups: (array) ($data->groups ?? []),
            name: (string) ($data->name ?? ''),
            published: (bool) ($data->published ?? false),
        );
    }
}
