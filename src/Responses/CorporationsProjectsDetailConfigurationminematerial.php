<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailConfigurationminematerial extends AbstractEsiDto
{
    public function __construct(
        public readonly ?array $locations = null,
        public readonly ?array $materials = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            locations: isset($data->locations) ? (array) $data->locations : null,
            materials: isset($data->materials) ? (array) $data->materials : null,
        );
    }
}
