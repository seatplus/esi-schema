<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdOrdersGetItem;
use Seatplus\EsiSchema\Operations\Market\GetCharactersCharacterIdOrders;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdOrdersHistoryGetItem;
use Seatplus\EsiSchema\Operations\Market\GetCharactersCharacterIdOrdersHistory;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdOrdersGetItem;
use Seatplus\EsiSchema\Operations\Market\GetCorporationsCorporationIdOrders;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdOrdersHistoryGetItem;
use Seatplus\EsiSchema\Operations\Market\GetCorporationsCorporationIdOrdersHistory;
use Seatplus\EsiSchema\Operations\Market\GetMarketsGroups;
use Seatplus\EsiSchema\Responses\MarketsGroupsMarketGroupIdGet;
use Seatplus\EsiSchema\Operations\Market\GetMarketsGroupsMarketGroupId;
use Seatplus\EsiSchema\Responses\MarketsPricesGetItem;
use Seatplus\EsiSchema\Operations\Market\GetMarketsPrices;
use Seatplus\EsiSchema\Responses\MarketsStructuresStructureIdGetItem;
use Seatplus\EsiSchema\Operations\Market\GetMarketsStructuresStructureId;
use Seatplus\EsiSchema\Responses\MarketsRegionIdHistoryGetItem;
use Seatplus\EsiSchema\Operations\Market\GetMarketsRegionIdHistory;
use Seatplus\EsiSchema\Responses\MarketsRegionIdOrdersGetItem;
use Seatplus\EsiSchema\Operations\Market\GetMarketsRegionIdOrders;
use Seatplus\EsiSchema\Operations\Market\GetMarketsRegionIdTypes;

/**
 * ESI tag: Market
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class MarketResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdOrders' => GetCharactersCharacterIdOrders::meta(),
            'getCharactersCharacterIdOrdersHistory' => GetCharactersCharacterIdOrdersHistory::meta(),
            'getCorporationsCorporationIdOrders' => GetCorporationsCorporationIdOrders::meta(),
            'getCorporationsCorporationIdOrdersHistory' => GetCorporationsCorporationIdOrdersHistory::meta(),
            'getMarketsGroups' => GetMarketsGroups::meta(),
            'getMarketsGroupsMarketGroupId' => GetMarketsGroupsMarketGroupId::meta(),
            'getMarketsPrices' => GetMarketsPrices::meta(),
            'getMarketsStructuresStructureId' => GetMarketsStructuresStructureId::meta(),
            'getMarketsRegionIdHistory' => GetMarketsRegionIdHistory::meta(),
            'getMarketsRegionIdOrders' => GetMarketsRegionIdOrders::meta(),
            'getMarketsRegionIdTypes' => GetMarketsRegionIdTypes::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdOrders. Equivalent to GetCharactersCharacterIdOrders::meta(). */
    public static function getCharactersCharacterIdOrdersMeta(): OperationMeta
    {
        return GetCharactersCharacterIdOrders::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdOrdersHistory. Equivalent to GetCharactersCharacterIdOrdersHistory::meta(). */
    public static function getCharactersCharacterIdOrdersHistoryMeta(): OperationMeta
    {
        return GetCharactersCharacterIdOrdersHistory::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdOrders. Equivalent to GetCorporationsCorporationIdOrders::meta(). */
    public static function getCorporationsCorporationIdOrdersMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdOrders::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdOrdersHistory. Equivalent to GetCorporationsCorporationIdOrdersHistory::meta(). */
    public static function getCorporationsCorporationIdOrdersHistoryMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdOrdersHistory::meta();
    }

    /** Pre-call metadata for getMarketsGroups. Equivalent to GetMarketsGroups::meta(). */
    public static function getMarketsGroupsMeta(): OperationMeta
    {
        return GetMarketsGroups::meta();
    }

    /** Pre-call metadata for getMarketsGroupsMarketGroupId. Equivalent to GetMarketsGroupsMarketGroupId::meta(). */
    public static function getMarketsGroupsMarketGroupIdMeta(): OperationMeta
    {
        return GetMarketsGroupsMarketGroupId::meta();
    }

    /** Pre-call metadata for getMarketsPrices. Equivalent to GetMarketsPrices::meta(). */
    public static function getMarketsPricesMeta(): OperationMeta
    {
        return GetMarketsPrices::meta();
    }

    /** Pre-call metadata for getMarketsStructuresStructureId. Equivalent to GetMarketsStructuresStructureId::meta(). */
    public static function getMarketsStructuresStructureIdMeta(): OperationMeta
    {
        return GetMarketsStructuresStructureId::meta();
    }

    /** Pre-call metadata for getMarketsRegionIdHistory. Equivalent to GetMarketsRegionIdHistory::meta(). */
    public static function getMarketsRegionIdHistoryMeta(): OperationMeta
    {
        return GetMarketsRegionIdHistory::meta();
    }

    /** Pre-call metadata for getMarketsRegionIdOrders. Equivalent to GetMarketsRegionIdOrders::meta(). */
    public static function getMarketsRegionIdOrdersMeta(): OperationMeta
    {
        return GetMarketsRegionIdOrders::meta();
    }

    /** Pre-call metadata for getMarketsRegionIdTypes. Equivalent to GetMarketsRegionIdTypes::meta(). */
    public static function getMarketsRegionIdTypesMeta(): OperationMeta
    {
        return GetMarketsRegionIdTypes::meta();
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdOrdersGetItem>>
     * @scope esi-markets.read_character_orders.v1
     */
    public function getCharactersCharacterIdOrders(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/orders', ['character_id' => $characterId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdOrdersGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdOrdersHistoryGetItem>>
     * @scope esi-markets.read_character_orders.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdOrdersHistory(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/orders/history', ['character_id' => $characterId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdOrdersHistoryGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdOrdersGetItem>>
     * @scope esi-markets.read_corporation_orders.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdOrders(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/orders', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdOrdersGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdOrdersHistoryGetItem>>
     * @scope esi-markets.read_corporation_orders.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdOrdersHistory(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/orders/history', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdOrdersHistoryGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getMarketsGroups(): EsiResult
    {
        $response = $this->transport->invoke('get', '/markets/groups', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return MarketsGroupsMarketGroupIdGet
     */
    public function getMarketsGroupsMarketGroupId(int $marketGroupId): MarketsGroupsMarketGroupIdGet
    {
        $response = $this->transport->invoke('get', '/markets/groups/{market_group_id}', ['market_group_id' => $marketGroupId], []);
        $dto = MarketsGroupsMarketGroupIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<MarketsPricesGetItem>>
     */
    public function getMarketsPrices(): EsiResult
    {
        $response = $this->transport->invoke('get', '/markets/prices', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => MarketsPricesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<MarketsStructuresStructureIdGetItem>>
     * @scope esi-markets.structure_markets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getMarketsStructuresStructureId(int $structureId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/markets/structures/{structure_id}', ['structure_id' => $structureId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => MarketsStructuresStructureIdGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<MarketsRegionIdHistoryGetItem>>
     */
    public function getMarketsRegionIdHistory(int $regionId, int $typeId): EsiResult
    {
        $response = $this->transport->invoke('get', '/markets/{region_id}/history', ['region_id' => $regionId], ['type_id' => $typeId]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => MarketsRegionIdHistoryGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<MarketsRegionIdOrdersGetItem>>
     * @paginated Use $page param to iterate pages.
     */
    public function getMarketsRegionIdOrders(string $orderType, int $regionId, int $page = 1, ?int $typeId = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/markets/{region_id}/orders', ['region_id' => $regionId], ['order_type' => $orderType, 'page' => $page, 'type_id' => $typeId]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => MarketsRegionIdOrdersGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<int>>
     * @paginated Use $page param to iterate pages.
     */
    public function getMarketsRegionIdTypes(int $regionId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/markets/{region_id}/types', ['region_id' => $regionId], ['page' => $page]);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }
}
