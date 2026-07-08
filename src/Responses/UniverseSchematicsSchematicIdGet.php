<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseSchematicsSchematicIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly int $cycle_time,
        public readonly string $schematic_name,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            cycle_time: (int) ($data->cycle_time ?? 0),
            schematic_name: (string) ($data->schematic_name ?? ''),
        );
    }
}
