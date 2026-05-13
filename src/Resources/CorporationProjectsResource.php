<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsProjectsListing;
use Seatplus\EsiSchema\Operations\CorporationProjects\GetCorporationsProjectsListing;
use Seatplus\EsiSchema\Responses\CorporationsProjectsDetail;
use Seatplus\EsiSchema\Operations\CorporationProjects\GetCorporationsProjectsDetail;
use Seatplus\EsiSchema\Responses\CorporationsProjectsContribution;
use Seatplus\EsiSchema\Operations\CorporationProjects\GetCorporationsProjectsContribution;
use Seatplus\EsiSchema\Responses\CorporationsProjectsContributors;
use Seatplus\EsiSchema\Operations\CorporationProjects\GetCorporationsProjectsContributors;

/**
 * ESI tag: CorporationProjects
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class CorporationProjectsResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCorporationsProjectsListing' => GetCorporationsProjectsListing::meta(),
            'getCorporationsProjectsDetail' => GetCorporationsProjectsDetail::meta(),
            'getCorporationsProjectsContribution' => GetCorporationsProjectsContribution::meta(),
            'getCorporationsProjectsContributors' => GetCorporationsProjectsContributors::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCorporationsProjectsListing. Equivalent to GetCorporationsProjectsListing::meta(). */
    public static function getCorporationsProjectsListingMeta(): OperationMeta
    {
        return GetCorporationsProjectsListing::meta();
    }

    /** Pre-call metadata for getCorporationsProjectsDetail. Equivalent to GetCorporationsProjectsDetail::meta(). */
    public static function getCorporationsProjectsDetailMeta(): OperationMeta
    {
        return GetCorporationsProjectsDetail::meta();
    }

    /** Pre-call metadata for getCorporationsProjectsContribution. Equivalent to GetCorporationsProjectsContribution::meta(). */
    public static function getCorporationsProjectsContributionMeta(): OperationMeta
    {
        return GetCorporationsProjectsContribution::meta();
    }

    /** Pre-call metadata for getCorporationsProjectsContributors. Equivalent to GetCorporationsProjectsContributors::meta(). */
    public static function getCorporationsProjectsContributorsMeta(): OperationMeta
    {
        return GetCorporationsProjectsContributors::meta();
    }

    /**
     * @return CorporationsProjectsListing
     * @scope esi-corporations.read_projects.v1
     */
    public function getCorporationsProjectsListing(int $corporationId, ?string $after = null, ?string $before = null, ?int $limit = null, ?string $state = null): CorporationsProjectsListing
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/projects', ['corporation_id' => $corporationId], ['after' => $after, 'before' => $before, 'limit' => $limit, 'state' => $state]);
        $dto = CorporationsProjectsListing::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCorporationsProjectsListing::meta();
        return $dto;
    }

    /**
     * @return CorporationsProjectsDetail
     * @scope esi-corporations.read_projects.v1
     */
    public function getCorporationsProjectsDetail(int $corporationId, string $projectId): CorporationsProjectsDetail
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/projects/{project_id}', ['corporation_id' => $corporationId, 'project_id' => $projectId], []);
        $dto = CorporationsProjectsDetail::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCorporationsProjectsDetail::meta();
        return $dto;
    }

    /**
     * @return CorporationsProjectsContribution
     * @scope esi-corporations.read_projects.v1
     */
    public function getCorporationsProjectsContribution(int $corporationId, string $projectId, int $characterId): CorporationsProjectsContribution
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/projects/{project_id}/contribution/{character_id}', ['corporation_id' => $corporationId, 'project_id' => $projectId, 'character_id' => $characterId], []);
        $dto = CorporationsProjectsContribution::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCorporationsProjectsContribution::meta();
        return $dto;
    }

    /**
     * @return CorporationsProjectsContributors
     * @scope esi-corporations.read_projects.v1
     */
    public function getCorporationsProjectsContributors(int $corporationId, string $projectId, ?string $after = null, ?string $before = null, ?int $limit = null): CorporationsProjectsContributors
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/projects/{project_id}/contributors', ['corporation_id' => $corporationId, 'project_id' => $projectId], ['after' => $after, 'before' => $before, 'limit' => $limit]);
        $dto = CorporationsProjectsContributors::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCorporationsProjectsContributors::meta();
        return $dto;
    }
}
