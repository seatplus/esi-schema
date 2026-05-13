<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\FreelanceJobs;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\FreelanceJobsDetail;

/**
 * ESI operation: getFreelanceJobsDetail
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetFreelanceJobsDetail implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 60, 'rateLimit' => ['group' => 'freelance-job', 'max-tokens' => 900, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return FreelanceJobsDetail
     */
    public static function execute(EsiTransportInterface $transport, string $jobId): FreelanceJobsDetail
    {
        $response = $transport->invoke('get', '/freelance-jobs/{job_id}', ['job_id' => $jobId], []);
        $dto = FreelanceJobsDetail::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
