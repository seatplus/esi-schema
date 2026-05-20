<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsContribution extends AbstractEsiDto
{
    public function __construct(
        public readonly int $contributed,
        public readonly ?string $last_modified = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            contributed: (int) ($data->contributed ?? 0),
            last_modified: $data->last_modified ?? null,
        );
    }
}
