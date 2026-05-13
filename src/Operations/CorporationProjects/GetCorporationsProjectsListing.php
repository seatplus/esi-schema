<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\CorporationProjects;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsProjectsListing;

/**
 * ESI operation: getCorporationsProjectsListing
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsProjectsListing implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 0, 'rateLimit' => ['group' => 'corp-project', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => true, 'requiredScope' => 'esi-corporations.read_projects.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CorporationsProjectsListing
     * @scope esi-corporations.read_projects.v1
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, ?string $after = null, ?string $before = null, ?int $limit = null, ?string $state = null): CorporationsProjectsListing
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/projects', ['corporation_id' => $corporationId], ['after' => $after, 'before' => $before, 'limit' => $limit, 'state' => $state]);
        $dto = CorporationsProjectsListing::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
