<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdOrdersGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdOrdersHistoryGetItem;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdOrdersGetItem;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdOrdersHistoryGetItem;
use Seatplus\EsiSchema\Responses\MarketsGroupsMarketGroupIdGet;
use Seatplus\EsiSchema\Responses\MarketsPricesGetItem;
use Seatplus\EsiSchema\Responses\MarketsStructuresStructureIdGetItem;
use Seatplus\EsiSchema\Responses\MarketsRegionIdHistoryGetItem;
use Seatplus\EsiSchema\Responses\MarketsRegionIdOrdersGetItem;

/**
 * ESI tag: Market
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class MarketResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCharactersCharacterIdOrders' => ['cacheAge' => 1200, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-markets.read_character_orders.v1'],
        'getCharactersCharacterIdOrdersHistory' => ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-markets.read_character_orders.v1'],
        'getCorporationsCorporationIdOrders' => ['cacheAge' => 1200, 'rateLimit' => null, 'requiredRoles' => ['Accountant', 'Trader'], 'cursor' => false, 'requiredScope' => 'esi-markets.read_corporation_orders.v1'],
        'getCorporationsCorporationIdOrdersHistory' => ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => ['Accountant', 'Trader'], 'cursor' => false, 'requiredScope' => 'esi-markets.read_corporation_orders.v1'],
        'getMarketsGroups' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
        'getMarketsGroupsMarketGroupId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
        'getMarketsPrices' => ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
        'getMarketsStructuresStructureId' => ['cacheAge' => 300, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-markets.structure_markets.v1'],
        'getMarketsRegionIdHistory' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
        'getMarketsRegionIdOrders' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'market-order', 'max-tokens' => 12000, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
        'getMarketsRegionIdTypes' => ['cacheAge' => 600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
    ];

    /**
     * @return EsiResult<array<CharactersCharacterIdOrdersGetItem>>
     * @scope esi-markets.read_character_orders.v1
     */
    public function getCharactersCharacterIdOrders(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/orders', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdOrdersGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdOrders'] ?? null);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdOrdersHistoryGetItem>>
     * @scope esi-markets.read_character_orders.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdOrdersHistory(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/orders/history', ['character_id' => $characterId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdOrdersHistoryGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdOrdersHistory'] ?? null);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdOrdersGetItem>>
     * @scope esi-markets.read_corporation_orders.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdOrders(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/orders', ['corporation_id' => $corporationId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdOrdersGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCorporationsCorporationIdOrders'] ?? null);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdOrdersHistoryGetItem>>
     * @scope esi-markets.read_corporation_orders.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdOrdersHistory(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/orders/history', ['corporation_id' => $corporationId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdOrdersHistoryGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCorporationsCorporationIdOrdersHistory'] ?? null);
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getMarketsGroups(): EsiResult
    {
        $response = $this->transport->invoke('get', '/markets/groups', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getMarketsGroups'] ?? null);
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
        $dto->operationMeta = static::OPERATION_META['getMarketsGroupsMarketGroupId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<array<MarketsPricesGetItem>>
     */
    public function getMarketsPrices(): EsiResult
    {
        $response = $this->transport->invoke('get', '/markets/prices', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => MarketsPricesGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getMarketsPrices'] ?? null);
    }

    /**
     * @return EsiResult<array<MarketsStructuresStructureIdGetItem>>
     * @scope esi-markets.structure_markets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getMarketsStructuresStructureId(int $structureId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/markets/structures/{structure_id}', ['structure_id' => $structureId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => MarketsStructuresStructureIdGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getMarketsStructuresStructureId'] ?? null);
    }

    /**
     * @return EsiResult<array<MarketsRegionIdHistoryGetItem>>
     */
    public function getMarketsRegionIdHistory(int $regionId, int $typeId): EsiResult
    {
        $response = $this->transport->invoke('get', '/markets/{region_id}/history', ['region_id' => $regionId], ['type_id' => $typeId]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => MarketsRegionIdHistoryGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getMarketsRegionIdHistory'] ?? null);
    }

    /**
     * @return EsiResult<array<MarketsRegionIdOrdersGetItem>>
     * @paginated Use $page param to iterate pages.
     */
    public function getMarketsRegionIdOrders(string $orderType, int $regionId, int $page = 1, ?int $typeId = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/markets/{region_id}/orders', ['region_id' => $regionId], ['order_type' => $orderType, 'page' => $page, 'type_id' => $typeId]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => MarketsRegionIdOrdersGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getMarketsRegionIdOrders'] ?? null);
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
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getMarketsRegionIdTypes'] ?? null);
    }
}
