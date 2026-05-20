<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UniverseStargatesStargateIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly mixed $destination,
        public readonly string $name,
        public readonly mixed $position,
        public readonly int $stargate_id,
        public readonly int $system_id,
        public readonly int $type_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            destination: ($data->destination ?? null),
            name: (string) ($data->name ?? ''),
            position: ($data->position ?? null),
            stargate_id: (int) ($data->stargate_id ?? 0),
            system_id: (int) ($data->system_id ?? 0),
            type_id: (int) ($data->type_id ?? 0),
        );
    }
}
