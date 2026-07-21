<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsDetail extends AbstractEsiDto
{
    public function __construct(
        public readonly int $id,
        public readonly CorporationsStructuresSovereigntyHubsDetailReagentbay $reagent_bay,
        public readonly CorporationsStructuresSovereigntyHubsDetailResources $resources,
        public readonly int $solar_system_id,
        public readonly array $upgrades,
        public readonly CorporationsStructuresSovereigntyHubsDetailTransport $workforce_transport,
        public readonly ?int $fuel_access_list_id = null,
        public readonly ?CorporationsStructuresSovereigntyHubsDetailVulnerabilitywindow $vulnerability_window = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            id: (int) ($data->id ?? 0),
            reagent_bay: CorporationsStructuresSovereigntyHubsDetailReagentbay::from($data->reagent_bay ?? new \stdClass()),
            resources: CorporationsStructuresSovereigntyHubsDetailResources::from($data->resources ?? new \stdClass()),
            solar_system_id: (int) ($data->solar_system_id ?? 0),
            upgrades: array_map(fn (object $i) => CorporationsStructuresSovereigntyHubsDetailUpgrade::from($i), (array) ($data->upgrades ?? [])),
            workforce_transport: CorporationsStructuresSovereigntyHubsDetailTransport::from($data->workforce_transport ?? new \stdClass()),
            fuel_access_list_id: $data->fuel_access_list_id ?? null,
            vulnerability_window: isset($data->vulnerability_window) ? CorporationsStructuresSovereigntyHubsDetailVulnerabilitywindow::from($data->vulnerability_window) : null,
        );
    }
}
