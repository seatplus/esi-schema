<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdIndustryJobsGetItem;

/**
 * ESI operation: getCorporationsCorporationIdIndustryJobs
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdIndustryJobs implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 300, 'rateLimit' => ['group' => 'corp-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => ['Factory_Manager'], 'cursor' => false, 'requiredScope' => 'esi-industry.read_corporation_jobs.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdIndustryJobsGetItem>>
     * @scope esi-industry.read_corporation_jobs.v1
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, ?bool $includeCompleted = null, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/industry/jobs', ['corporation_id' => $corporationId], ['include_completed' => $includeCompleted, 'page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdIndustryJobsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
