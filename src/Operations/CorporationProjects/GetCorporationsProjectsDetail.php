<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\CorporationProjects;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsProjectsDetail;

/**
 * ESI operation: getCorporationsProjectsDetail
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsProjectsDetail implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 60, 'rateLimit' => ['group' => 'corp-project', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-corporations.read_projects.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CorporationsProjectsDetail
     * @scope esi-corporations.read_projects.v1
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, string $projectId): CorporationsProjectsDetail
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/projects/{project_id}', ['corporation_id' => $corporationId, 'project_id' => $projectId], []);
        $dto = CorporationsProjectsDetail::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
