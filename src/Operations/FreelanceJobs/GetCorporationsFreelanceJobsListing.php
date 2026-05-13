<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\FreelanceJobs;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsFreelanceJobsListing;

/**
 * ESI operation: getCorporationsFreelanceJobsListing
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsFreelanceJobsListing implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 0, 'rateLimit' => ['group' => 'corp-freelance-job', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => ['Project_Manager'], 'cursor' => true, 'requiredScope' => 'esi-corporations.read_freelance_jobs.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CorporationsFreelanceJobsListing
     * @scope esi-corporations.read_freelance_jobs.v1
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, ?string $after = null, ?string $before = null, ?int $limit = null): CorporationsFreelanceJobsListing
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/freelance-jobs', ['corporation_id' => $corporationId], ['after' => $after, 'before' => $before, 'limit' => $limit]);
        $dto = CorporationsFreelanceJobsListing::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
