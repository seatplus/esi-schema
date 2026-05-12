<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdIndustryJobsGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMiningGetItem;
use Seatplus\EsiSchema\Responses\CorporationCorporationIdMiningExtractionsGetItem;
use Seatplus\EsiSchema\Responses\CorporationCorporationIdMiningObserversGetItem;
use Seatplus\EsiSchema\Responses\CorporationCorporationIdMiningObserversObserverIdGetItem;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdIndustryJobsGetItem;
use Seatplus\EsiSchema\Responses\IndustryFacilitiesGetItem;
use Seatplus\EsiSchema\Responses\IndustrySystemsGetItem;

/**
 * ESI tag: Industry
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class IndustryResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCharactersCharacterIdIndustryJobs' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'char-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdMining' => ['cacheAge' => 600, 'rateLimit' => ['group' => 'char-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCorporationCorporationIdMiningExtractions' => ['cacheAge' => 1800, 'rateLimit' => ['group' => 'corp-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => ['Station_Manager'], 'cursor' => false],
        'getCorporationCorporationIdMiningObservers' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'corp-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => ['Accountant'], 'cursor' => false],
        'getCorporationCorporationIdMiningObserversObserverId' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'corp-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => ['Accountant'], 'cursor' => false],
        'getCorporationsCorporationIdIndustryJobs' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'corp-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => ['Factory_Manager'], 'cursor' => false],
        'getIndustryFacilities' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'industry', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getIndustrySystems' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'industry', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
    ];

    /**
     * @return EsiResult<array<CharactersCharacterIdIndustryJobsGetItem>>
     * @scope esi-industry.read_character_jobs.v1
     */
    public function getCharactersCharacterIdIndustryJobs(int $characterId, ?bool $includeCompleted = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/industry/jobs', ['character_id' => $characterId], ['include_completed' => $includeCompleted]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdIndustryJobsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdIndustryJobs'] ?? null);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdMiningGetItem>>
     * @scope esi-industry.read_character_mining.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdMining(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/mining', ['character_id' => $characterId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdMiningGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdMining'] ?? null);
    }

    /**
     * @return EsiResult<array<CorporationCorporationIdMiningExtractionsGetItem>>
     * @scope esi-industry.read_corporation_mining.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationCorporationIdMiningExtractions(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporation/{corporation_id}/mining/extractions', ['corporation_id' => $corporationId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationCorporationIdMiningExtractionsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCorporationCorporationIdMiningExtractions'] ?? null);
    }

    /**
     * @return EsiResult<array<CorporationCorporationIdMiningObserversGetItem>>
     * @scope esi-industry.read_corporation_mining.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationCorporationIdMiningObservers(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporation/{corporation_id}/mining/observers', ['corporation_id' => $corporationId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationCorporationIdMiningObserversGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCorporationCorporationIdMiningObservers'] ?? null);
    }

    /**
     * @return EsiResult<array<CorporationCorporationIdMiningObserversObserverIdGetItem>>
     * @scope esi-industry.read_corporation_mining.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationCorporationIdMiningObserversObserverId(int $corporationId, int $observerId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporation/{corporation_id}/mining/observers/{observer_id}', ['corporation_id' => $corporationId, 'observer_id' => $observerId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationCorporationIdMiningObserversObserverIdGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCorporationCorporationIdMiningObserversObserverId'] ?? null);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdIndustryJobsGetItem>>
     * @scope esi-industry.read_corporation_jobs.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdIndustryJobs(int $corporationId, ?bool $includeCompleted = null, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/industry/jobs', ['corporation_id' => $corporationId], ['include_completed' => $includeCompleted, 'page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdIndustryJobsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCorporationsCorporationIdIndustryJobs'] ?? null);
    }

    /**
     * @return EsiResult<array<IndustryFacilitiesGetItem>>
     */
    public function getIndustryFacilities(): EsiResult
    {
        $response = $this->transport->invoke('get', '/industry/facilities', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => IndustryFacilitiesGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getIndustryFacilities'] ?? null);
    }

    /**
     * @return EsiResult<array<IndustrySystemsGetItem>>
     */
    public function getIndustrySystems(): EsiResult
    {
        $response = $this->transport->invoke('get', '/industry/systems', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => IndustrySystemsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getIndustrySystems'] ?? null);
    }
}
