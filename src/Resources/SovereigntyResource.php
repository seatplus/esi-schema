<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\SovereigntyCampaignsGetItem;
use Seatplus\EsiSchema\Operations\Sovereignty\GetSovereigntyCampaigns;
use Seatplus\EsiSchema\Responses\SovereigntyMapGetItem;
use Seatplus\EsiSchema\Operations\Sovereignty\GetSovereigntyMap;
use Seatplus\EsiSchema\Responses\SovereigntyStructuresGetItem;
use Seatplus\EsiSchema\Operations\Sovereignty\GetSovereigntyStructures;

/**
 * ESI tag: Sovereignty
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class SovereigntyResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getSovereigntyCampaigns' => GetSovereigntyCampaigns::meta(),
            'getSovereigntyMap' => GetSovereigntyMap::meta(),
            'getSovereigntyStructures' => GetSovereigntyStructures::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getSovereigntyCampaigns. Equivalent to GetSovereigntyCampaigns::meta(). */
    public static function getSovereigntyCampaignsMeta(): OperationMeta
    {
        return GetSovereigntyCampaigns::meta();
    }

    /** Pre-call metadata for getSovereigntyMap. Equivalent to GetSovereigntyMap::meta(). */
    public static function getSovereigntyMapMeta(): OperationMeta
    {
        return GetSovereigntyMap::meta();
    }

    /** Pre-call metadata for getSovereigntyStructures. Equivalent to GetSovereigntyStructures::meta(). */
    public static function getSovereigntyStructuresMeta(): OperationMeta
    {
        return GetSovereigntyStructures::meta();
    }

    /**
     * @return EsiResult<array<SovereigntyCampaignsGetItem>>
     */
    public function getSovereigntyCampaigns(): EsiResult
    {
        $response = $this->transport->invoke('get', '/sovereignty/campaigns', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => SovereigntyCampaignsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetSovereigntyCampaigns::meta(),
        );
    }

    /**
     * @return EsiResult<array<SovereigntyMapGetItem>>
     */
    public function getSovereigntyMap(): EsiResult
    {
        $response = $this->transport->invoke('get', '/sovereignty/map', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => SovereigntyMapGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetSovereigntyMap::meta(),
        );
    }

    /**
     * @return EsiResult<array<SovereigntyStructuresGetItem>>
     */
    public function getSovereigntyStructures(): EsiResult
    {
        $response = $this->transport->invoke('get', '/sovereignty/structures', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => SovereigntyStructuresGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetSovereigntyStructures::meta(),
        );
    }
}
