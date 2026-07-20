<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Market\GetCharactersCharacterIdOrders;
use Seatplus\EsiSchema\Resources\Market\GetCharactersCharacterIdOrdersHistory;
use Seatplus\EsiSchema\Resources\Market\GetCorporationsCorporationIdOrders;
use Seatplus\EsiSchema\Resources\Market\GetCorporationsCorporationIdOrdersHistory;
use Seatplus\EsiSchema\Resources\Market\GetMarketsGroups;
use Seatplus\EsiSchema\Resources\Market\GetMarketsGroupsMarketGroupId;
use Seatplus\EsiSchema\Responses\MarketsGroupsMarketGroupIdGet;
use Seatplus\EsiSchema\Resources\Market\GetMarketsPrices;
use Seatplus\EsiSchema\Resources\Market\GetMarketsStructuresStructureId;
use Seatplus\EsiSchema\Resources\Market\GetMarketsRegionIdHistory;
use Seatplus\EsiSchema\Resources\Market\GetMarketsRegionIdOrders;
use Seatplus\EsiSchema\Resources\Market\GetMarketsRegionIdTypes;

/**
 * ESI Market resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class MarketResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     * @scope esi-markets.read_character_orders.v1
     */
    public function getCharactersCharacterIdOrders(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdOrders::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-markets.read_character_orders.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdOrdersHistory(int $characterId, int $page = 1): EsiResult
    {
        return GetCharactersCharacterIdOrdersHistory::execute($this->transport, $characterId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-markets.read_corporation_orders.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdOrders(int $corporationId, int $page = 1): EsiResult
    {
        return GetCorporationsCorporationIdOrders::execute($this->transport, $corporationId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-markets.read_corporation_orders.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdOrdersHistory(int $corporationId, int $page = 1): EsiResult
    {
        return GetCorporationsCorporationIdOrdersHistory::execute($this->transport, $corporationId, $page);
    }

    /**
     * @return EsiResult
     */
    public function getMarketsGroups(): EsiResult
    {
        return GetMarketsGroups::execute($this->transport);
    }

    /**
     * @return MarketsGroupsMarketGroupIdGet
     */
    public function getMarketsGroupsMarketGroupId(int $marketGroupId): MarketsGroupsMarketGroupIdGet
    {
        return GetMarketsGroupsMarketGroupId::execute($this->transport, $marketGroupId);
    }

    /**
     * @return EsiResult
     */
    public function getMarketsPrices(): EsiResult
    {
        return GetMarketsPrices::execute($this->transport);
    }

    /**
     * @return EsiResult
     * @scope esi-markets.structure_markets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getMarketsStructuresStructureId(int $structureId, int $page = 1): EsiResult
    {
        return GetMarketsStructuresStructureId::execute($this->transport, $structureId, $page);
    }

    /**
     * @return EsiResult
     */
    public function getMarketsRegionIdHistory(int $regionId, int $typeId): EsiResult
    {
        return GetMarketsRegionIdHistory::execute($this->transport, $regionId, $typeId);
    }

    /**
     * @return EsiResult
     * @paginated Use $page param to iterate pages.
     */
    public function getMarketsRegionIdOrders(string $orderType, int $regionId, int $page = 1, ?int $typeId = null): EsiResult
    {
        return GetMarketsRegionIdOrders::execute($this->transport, $orderType, $regionId, $page, $typeId);
    }

    /**
     * @return EsiResult
     * @paginated Use $page param to iterate pages.
     */
    public function getMarketsRegionIdTypes(int $regionId, int $page = 1): EsiResult
    {
        return GetMarketsRegionIdTypes::execute($this->transport, $regionId, $page);
    }
}
