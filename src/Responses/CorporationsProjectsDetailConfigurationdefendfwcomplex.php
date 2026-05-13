<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailConfigurationdefendfwcomplex extends AbstractEsiDto
{
    public function __construct(
        public readonly ?array $archetypes = null,
        public readonly ?array $factions = null,
        public readonly ?array $locations = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            archetypes: isset($data->archetypes) ? (array) $data->archetypes : null,
            factions: isset($data->factions) ? (array) $data->factions : null,
            locations: isset($data->locations) ? (array) $data->locations : null,
        );
    }
}
