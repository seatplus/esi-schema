<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsListingSovereigntyhub extends AbstractEsiDto
{
    public function __construct(
        public readonly int $id,
        public readonly int $solar_system_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            id: (int) ($data->id ?? 0),
            solar_system_id: (int) ($data->solar_system_id ?? 0),
        );
    }
}
