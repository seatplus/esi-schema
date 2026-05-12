<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Responses\CorporationsProjectsListing;
use Seatplus\EsiSchema\Responses\CorporationsProjectsDetail;
use Seatplus\EsiSchema\Responses\CorporationsProjectsContribution;
use Seatplus\EsiSchema\Responses\CorporationsProjectsContributors;

/**
 * ESI tag: CorporationProjects
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class CorporationProjectsResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCorporationsProjectsListing' => ['cacheAge' => 0, 'rateLimit' => ['group' => 'corp-project', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => true],
        'getCorporationsProjectsDetail' => ['cacheAge' => 60, 'rateLimit' => ['group' => 'corp-project', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCorporationsProjectsContribution' => ['cacheAge' => 60, 'rateLimit' => ['group' => 'corp-project', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCorporationsProjectsContributors' => ['cacheAge' => 0, 'rateLimit' => ['group' => 'corp-project', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => ['Project_Manager'], 'cursor' => true],
    ];

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
        $dto->operationMeta = static::OPERATION_META['getCorporationsProjectsListing'] ?? null;
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
        $dto->operationMeta = static::OPERATION_META['getCorporationsProjectsDetail'] ?? null;
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
        $dto->operationMeta = static::OPERATION_META['getCorporationsProjectsContribution'] ?? null;
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
        $dto->operationMeta = static::OPERATION_META['getCorporationsProjectsContributors'] ?? null;
        return $dto;
    }
}
