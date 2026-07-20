<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class SovereigntySystemsAlliance extends AbstractEsiDto
{
    public function __construct(
        public readonly int $alliance_id,
        public readonly string $claimed_since,
        public readonly int $corporation_id,
        public readonly SovereigntySystemsDevelopment $development,
        public readonly bool $is_capital_system,
        public readonly SovereigntySystemsSovereigntyhub $sovereignty_hub,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            alliance_id: (int) ($data->alliance_id ?? 0),
            claimed_since: (string) ($data->claimed_since ?? ''),
            corporation_id: (int) ($data->corporation_id ?? 0),
            development: SovereigntySystemsDevelopment::from($data->development ?? new \stdClass()),
            is_capital_system: (bool) ($data->is_capital_system ?? false),
            sovereignty_hub: SovereigntySystemsSovereigntyhub::from($data->sovereignty_hub ?? new \stdClass()),
        );
    }
}
