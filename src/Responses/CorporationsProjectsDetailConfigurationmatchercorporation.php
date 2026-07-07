<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailConfigurationmatchercorporation extends AbstractEsiDto
{
    public function __construct(
        public readonly ?int $corporation_id = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            corporation_id: $data->corporation_id ?? null,
        );
    }
}
