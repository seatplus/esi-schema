<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Industry\GetCharactersCharacterIdIndustryJobs;
use Seatplus\EsiSchema\Resources\Industry\GetCharactersCharacterIdMining;
use Seatplus\EsiSchema\Resources\Industry\GetCorporationCorporationIdMiningExtractions;
use Seatplus\EsiSchema\Resources\Industry\GetCorporationCorporationIdMiningObservers;
use Seatplus\EsiSchema\Resources\Industry\GetCorporationCorporationIdMiningObserversObserverId;
use Seatplus\EsiSchema\Resources\Industry\GetCorporationsCorporationIdIndustryJobs;
use Seatplus\EsiSchema\Resources\Industry\GetIndustryFacilities;
use Seatplus\EsiSchema\Resources\Industry\GetIndustrySystems;

/**
 * ESI Industry resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class IndustryResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     * @scope esi-industry.read_character_jobs.v1
     */
    public function getCharactersCharacterIdIndustryJobs(int $characterId, ?bool $includeCompleted = null): EsiResult
    {
        return GetCharactersCharacterIdIndustryJobs::execute($this->transport, $characterId, $includeCompleted);
    }

    /**
     * @return EsiResult
     * @scope esi-industry.read_character_mining.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdMining(int $characterId, int $page = 1): EsiResult
    {
        return GetCharactersCharacterIdMining::execute($this->transport, $characterId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-industry.read_corporation_mining.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationCorporationIdMiningExtractions(int $corporationId, int $page = 1): EsiResult
    {
        return GetCorporationCorporationIdMiningExtractions::execute($this->transport, $corporationId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-industry.read_corporation_mining.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationCorporationIdMiningObservers(int $corporationId, int $page = 1): EsiResult
    {
        return GetCorporationCorporationIdMiningObservers::execute($this->transport, $corporationId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-industry.read_corporation_mining.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationCorporationIdMiningObserversObserverId(int $corporationId, int $observerId, int $page = 1): EsiResult
    {
        return GetCorporationCorporationIdMiningObserversObserverId::execute($this->transport, $corporationId, $observerId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-industry.read_corporation_jobs.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdIndustryJobs(int $corporationId, ?bool $includeCompleted = null, int $page = 1): EsiResult
    {
        return GetCorporationsCorporationIdIndustryJobs::execute($this->transport, $corporationId, $includeCompleted, $page);
    }

    /**
     * @return EsiResult
     */
    public function getIndustryFacilities(): EsiResult
    {
        return GetIndustryFacilities::execute($this->transport);
    }

    /**
     * @return EsiResult
     */
    public function getIndustrySystems(): EsiResult
    {
        return GetIndustrySystems::execute($this->transport);
    }
}
