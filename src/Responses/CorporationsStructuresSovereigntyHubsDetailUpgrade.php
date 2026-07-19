<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsDetailUpgrade extends AbstractEsiDto
{
    public function __construct(
        public readonly string $power_state,
        public readonly int $type_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            power_state: (string) ($data->power_state ?? ''),
            type_id: (int) ($data->type_id ?? 0),
        );
    }
}
