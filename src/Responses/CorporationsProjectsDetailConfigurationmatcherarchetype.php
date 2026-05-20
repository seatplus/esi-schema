<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailConfigurationmatcherarchetype extends AbstractEsiDto
{
    public function __construct(
        public readonly ?int $archetype_id = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            archetype_id: $data->archetype_id ?? null,
        );
    }
}
