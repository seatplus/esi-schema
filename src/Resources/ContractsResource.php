<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Contracts\GetCharactersCharacterIdContracts;
use Seatplus\EsiSchema\Resources\Contracts\GetCharactersCharacterIdContractsContractIdBids;
use Seatplus\EsiSchema\Resources\Contracts\GetCharactersCharacterIdContractsContractIdItems;
use Seatplus\EsiSchema\Resources\Contracts\GetContractsPublicBidsContractId;
use Seatplus\EsiSchema\Resources\Contracts\GetContractsPublicItemsContractId;
use Seatplus\EsiSchema\Resources\Contracts\GetContractsPublicRegionId;
use Seatplus\EsiSchema\Resources\Contracts\GetCorporationsCorporationIdContracts;
use Seatplus\EsiSchema\Resources\Contracts\GetCorporationsCorporationIdContractsContractIdBids;
use Seatplus\EsiSchema\Resources\Contracts\GetCorporationsCorporationIdContractsContractIdItems;

/**
 * ESI Contracts resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class ContractsResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     * @scope esi-contracts.read_character_contracts.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdContracts(int $characterId, int $page = 1): EsiResult
    {
        return GetCharactersCharacterIdContracts::execute($this->transport, $characterId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-contracts.read_character_contracts.v1
     */
    public function getCharactersCharacterIdContractsContractIdBids(int $characterId, int $contractId): EsiResult
    {
        return GetCharactersCharacterIdContractsContractIdBids::execute($this->transport, $characterId, $contractId);
    }

    /**
     * @return EsiResult
     * @scope esi-contracts.read_character_contracts.v1
     */
    public function getCharactersCharacterIdContractsContractIdItems(int $characterId, int $contractId): EsiResult
    {
        return GetCharactersCharacterIdContractsContractIdItems::execute($this->transport, $characterId, $contractId);
    }

    /**
     * @return EsiResult
     * @paginated Use $page param to iterate pages.
     */
    public function getContractsPublicBidsContractId(int $contractId, int $page = 1): EsiResult
    {
        return GetContractsPublicBidsContractId::execute($this->transport, $contractId, $page);
    }

    /**
     * @return EsiResult
     * @paginated Use $page param to iterate pages.
     */
    public function getContractsPublicItemsContractId(int $contractId, int $page = 1): EsiResult
    {
        return GetContractsPublicItemsContractId::execute($this->transport, $contractId, $page);
    }

    /**
     * @return EsiResult
     * @paginated Use $page param to iterate pages.
     */
    public function getContractsPublicRegionId(int $regionId, int $page = 1): EsiResult
    {
        return GetContractsPublicRegionId::execute($this->transport, $regionId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-contracts.read_corporation_contracts.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdContracts(int $corporationId, int $page = 1): EsiResult
    {
        return GetCorporationsCorporationIdContracts::execute($this->transport, $corporationId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-contracts.read_corporation_contracts.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdContractsContractIdBids(int $contractId, int $corporationId, int $page = 1): EsiResult
    {
        return GetCorporationsCorporationIdContractsContractIdBids::execute($this->transport, $contractId, $corporationId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-contracts.read_corporation_contracts.v1
     */
    public function getCorporationsCorporationIdContractsContractIdItems(int $contractId, int $corporationId): EsiResult
    {
        return GetCorporationsCorporationIdContractsContractIdItems::execute($this->transport, $contractId, $corporationId);
    }
}
