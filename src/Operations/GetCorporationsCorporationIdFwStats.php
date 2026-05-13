<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdFwStatsGet;

/**
 * ESI operation: getCorporationsCorporationIdFwStats
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdFwStats implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => ['group' => 'factional-warfare', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-corporations.read_fw_stats.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CorporationsCorporationIdFwStatsGet
     * @scope esi-corporations.read_fw_stats.v1
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId): CorporationsCorporationIdFwStatsGet
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/fw/stats', ['corporation_id' => $corporationId], []);
        $dto = CorporationsCorporationIdFwStatsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
