<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailConfigurationscansignature extends AbstractEsiDto
{
    public function __construct(
        public readonly ?array $locations = null,
        public readonly ?array $signatures = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            locations: isset($data->locations) ? (array) $data->locations : null,
            signatures: isset($data->signatures) ? (array) $data->signatures : null,
        );
    }
}
