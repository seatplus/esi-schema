<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsDetailReagentbay extends AbstractEsiDto
{
    public function __construct(
        public readonly string $last_updated,
        public readonly array $reagents,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            last_updated: (string) ($data->last_updated ?? ''),
            reagents: array_map(fn (object $i) => CorporationsStructuresSovereigntyHubsDetailReagent::from($i), (array) ($data->reagents ?? [])),
        );
    }
}
