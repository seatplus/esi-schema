<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailConfigurationmatcherfaction extends AbstractEsiDto
{
    public function __construct(
        public readonly ?int $faction_id = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            faction_id: $data->faction_id ?? null,
        );
    }
}
