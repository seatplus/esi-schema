<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailConfigurationshipinsurance extends AbstractEsiDto
{
    public function __construct(
        public readonly string $conflict_type,
        public readonly bool $reimburse_implants,
        public readonly ?array $identities = null,
        public readonly ?array $locations = null,
        public readonly ?array $ships = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            conflict_type: (string) ($data->conflict_type ?? ''),
            reimburse_implants: (bool) ($data->reimburse_implants ?? false),
            identities: isset($data->identities) ? (array) $data->identities : null,
            locations: isset($data->locations) ? (array) $data->locations : null,
            ships: isset($data->ships) ? (array) $data->ships : null,
        );
    }
}
