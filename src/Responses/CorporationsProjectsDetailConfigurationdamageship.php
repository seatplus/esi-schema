<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailConfigurationdamageship extends AbstractEsiDto
{
    public function __construct(
        public readonly ?array $identities = null,
        public readonly ?array $locations = null,
        public readonly ?array $ships = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            identities: isset($data->identities) ? (array) $data->identities : null,
            locations: isset($data->locations) ? (array) $data->locations : null,
            ships: isset($data->ships) ? (array) $data->ships : null,
        );
    }
}
