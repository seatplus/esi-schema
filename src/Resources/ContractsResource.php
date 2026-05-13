<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdContractsGetItem;
use Seatplus\EsiSchema\Operations\Contracts\GetCharactersCharacterIdContracts;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdContractsContractIdBidsGetItem;
use Seatplus\EsiSchema\Operations\Contracts\GetCharactersCharacterIdContractsContractIdBids;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdContractsContractIdItemsGetItem;
use Seatplus\EsiSchema\Operations\Contracts\GetCharactersCharacterIdContractsContractIdItems;
use Seatplus\EsiSchema\Responses\ContractsPublicBidsContractIdGetItem;
use Seatplus\EsiSchema\Operations\Contracts\GetContractsPublicBidsContractId;
use Seatplus\EsiSchema\Responses\ContractsPublicItemsContractIdGetItem;
use Seatplus\EsiSchema\Operations\Contracts\GetContractsPublicItemsContractId;
use Seatplus\EsiSchema\Responses\ContractsPublicRegionIdGetItem;
use Seatplus\EsiSchema\Operations\Contracts\GetContractsPublicRegionId;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdContractsGetItem;
use Seatplus\EsiSchema\Operations\Contracts\GetCorporationsCorporationIdContracts;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdContractsContractIdBidsGetItem;
use Seatplus\EsiSchema\Operations\Contracts\GetCorporationsCorporationIdContractsContractIdBids;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdContractsContractIdItemsGetItem;
use Seatplus\EsiSchema\Operations\Contracts\GetCorporationsCorporationIdContractsContractIdItems;

/**
 * ESI tag: Contracts
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class ContractsResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdContracts' => GetCharactersCharacterIdContracts::meta(),
            'getCharactersCharacterIdContractsContractIdBids' => GetCharactersCharacterIdContractsContractIdBids::meta(),
            'getCharactersCharacterIdContractsContractIdItems' => GetCharactersCharacterIdContractsContractIdItems::meta(),
            'getContractsPublicBidsContractId' => GetContractsPublicBidsContractId::meta(),
            'getContractsPublicItemsContractId' => GetContractsPublicItemsContractId::meta(),
            'getContractsPublicRegionId' => GetContractsPublicRegionId::meta(),
            'getCorporationsCorporationIdContracts' => GetCorporationsCorporationIdContracts::meta(),
            'getCorporationsCorporationIdContractsContractIdBids' => GetCorporationsCorporationIdContractsContractIdBids::meta(),
            'getCorporationsCorporationIdContractsContractIdItems' => GetCorporationsCorporationIdContractsContractIdItems::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdContracts. Equivalent to GetCharactersCharacterIdContracts::meta(). */
    public static function getCharactersCharacterIdContractsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdContracts::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdContractsContractIdBids. Equivalent to GetCharactersCharacterIdContractsContractIdBids::meta(). */
    public static function getCharactersCharacterIdContractsContractIdBidsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdContractsContractIdBids::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdContractsContractIdItems. Equivalent to GetCharactersCharacterIdContractsContractIdItems::meta(). */
    public static function getCharactersCharacterIdContractsContractIdItemsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdContractsContractIdItems::meta();
    }

    /** Pre-call metadata for getContractsPublicBidsContractId. Equivalent to GetContractsPublicBidsContractId::meta(). */
    public static function getContractsPublicBidsContractIdMeta(): OperationMeta
    {
        return GetContractsPublicBidsContractId::meta();
    }

    /** Pre-call metadata for getContractsPublicItemsContractId. Equivalent to GetContractsPublicItemsContractId::meta(). */
    public static function getContractsPublicItemsContractIdMeta(): OperationMeta
    {
        return GetContractsPublicItemsContractId::meta();
    }

    /** Pre-call metadata for getContractsPublicRegionId. Equivalent to GetContractsPublicRegionId::meta(). */
    public static function getContractsPublicRegionIdMeta(): OperationMeta
    {
        return GetContractsPublicRegionId::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdContracts. Equivalent to GetCorporationsCorporationIdContracts::meta(). */
    public static function getCorporationsCorporationIdContractsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdContracts::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdContractsContractIdBids. Equivalent to GetCorporationsCorporationIdContractsContractIdBids::meta(). */
    public static function getCorporationsCorporationIdContractsContractIdBidsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdContractsContractIdBids::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdContractsContractIdItems. Equivalent to GetCorporationsCorporationIdContractsContractIdItems::meta(). */
    public static function getCorporationsCorporationIdContractsContractIdItemsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdContractsContractIdItems::meta();
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdContractsGetItem>>
     * @scope esi-contracts.read_character_contracts.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdContracts(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/contracts', ['character_id' => $characterId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdContractsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdContractsContractIdBidsGetItem>>
     * @scope esi-contracts.read_character_contracts.v1
     */
    public function getCharactersCharacterIdContractsContractIdBids(int $characterId, int $contractId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/contracts/{contract_id}/bids', ['character_id' => $characterId, 'contract_id' => $contractId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdContractsContractIdBidsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdContractsContractIdItemsGetItem>>
     * @scope esi-contracts.read_character_contracts.v1
     */
    public function getCharactersCharacterIdContractsContractIdItems(int $characterId, int $contractId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/contracts/{contract_id}/items', ['character_id' => $characterId, 'contract_id' => $contractId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdContractsContractIdItemsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<ContractsPublicBidsContractIdGetItem>>
     * @paginated Use $page param to iterate pages.
     */
    public function getContractsPublicBidsContractId(int $contractId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/contracts/public/bids/{contract_id}', ['contract_id' => $contractId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => ContractsPublicBidsContractIdGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<ContractsPublicItemsContractIdGetItem>>
     * @paginated Use $page param to iterate pages.
     */
    public function getContractsPublicItemsContractId(int $contractId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/contracts/public/items/{contract_id}', ['contract_id' => $contractId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => ContractsPublicItemsContractIdGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<ContractsPublicRegionIdGetItem>>
     * @paginated Use $page param to iterate pages.
     */
    public function getContractsPublicRegionId(int $regionId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/contracts/public/{region_id}', ['region_id' => $regionId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => ContractsPublicRegionIdGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdContractsGetItem>>
     * @scope esi-contracts.read_corporation_contracts.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdContracts(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/contracts', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdContractsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdContractsContractIdBidsGetItem>>
     * @scope esi-contracts.read_corporation_contracts.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdContractsContractIdBids(int $contractId, int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/contracts/{contract_id}/bids', ['contract_id' => $contractId, 'corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdContractsContractIdBidsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdContractsContractIdItemsGetItem>>
     * @scope esi-contracts.read_corporation_contracts.v1
     */
    public function getCorporationsCorporationIdContractsContractIdItems(int $contractId, int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/contracts/{contract_id}/items', ['contract_id' => $contractId, 'corporation_id' => $corporationId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdContractsContractIdItemsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }
}
