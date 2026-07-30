<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsContributorsContributor extends AbstractEsiDto
{
    public function __construct(
        public readonly int $contributed,
        public readonly int $id,
        public readonly string $name,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            contributed: (int) ($data->contributed ?? 0),
            id: (int) ($data->id ?? 0),
            name: (string) ($data->name ?? ''),
        );
    }
}
