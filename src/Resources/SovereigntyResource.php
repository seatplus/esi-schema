<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\SovereigntyCampaignsGetItem;
use Seatplus\EsiSchema\Responses\SovereigntyMapGetItem;
use Seatplus\EsiSchema\Responses\SovereigntyStructuresGetItem;

/**
 * ESI tag: Sovereignty
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class SovereigntyResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getSovereigntyCampaigns' => ['cacheAge' => 5, 'rateLimit' => ['group' => 'sovereignty', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getSovereigntyMap' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'sovereignty', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getSovereigntyStructures' => ['cacheAge' => 120, 'rateLimit' => ['group' => 'sovereignty', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
    ];

    /**
     * @return EsiResult<array<SovereigntyCampaignsGetItem>>
     */
    public function getSovereigntyCampaigns(): EsiResult
    {
        $response = $this->transport->invoke('get', '/sovereignty/campaigns', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => SovereigntyCampaignsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getSovereigntyCampaigns'] ?? null);
    }

    /**
     * @return EsiResult<array<SovereigntyMapGetItem>>
     */
    public function getSovereigntyMap(): EsiResult
    {
        $response = $this->transport->invoke('get', '/sovereignty/map', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => SovereigntyMapGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getSovereigntyMap'] ?? null);
    }

    /**
     * @return EsiResult<array<SovereigntyStructuresGetItem>>
     */
    public function getSovereigntyStructures(): EsiResult
    {
        $response = $this->transport->invoke('get', '/sovereignty/structures', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => SovereigntyStructuresGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getSovereigntyStructures'] ?? null);
    }
}
