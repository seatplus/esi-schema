<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\FreelanceJobs;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\FreelanceJobsListing;

/**
 * ESI operation: getFreelanceJobsListing
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetFreelanceJobsListing implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 0, 'rateLimit' => ['group' => 'freelance-job', 'max-tokens' => 900, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => true, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return FreelanceJobsListing
     */
    public static function execute(EsiTransportInterface $transport, ?string $after = null, ?string $before = null, ?int $limit = null, ?int $corporationId = null): FreelanceJobsListing
    {
        $response = $transport->invoke('get', '/freelance-jobs', [], ['after' => $after, 'before' => $before, 'limit' => $limit, 'corporation_id' => $corporationId]);
        $dto = FreelanceJobsListing::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
