<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseGroupsGroupIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly int $category_id,
        public readonly int $group_id,
        public readonly string $name,
        public readonly bool $published,
        public readonly array $types,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            category_id: (int) ($data->category_id ?? 0),
            group_id: (int) ($data->group_id ?? 0),
            name: (string) ($data->name ?? ''),
            published: (bool) ($data->published ?? false),
            types: (array) ($data->types ?? []),
        );
    }
}
