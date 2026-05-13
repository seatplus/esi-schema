<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdContainersLogsGetItem;

/**
 * ESI operation: getCorporationsCorporationIdContainersLogs
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdContainersLogs implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 600, 'rateLimit' => null, 'requiredRoles' => ['Director'], 'cursor' => false, 'requiredScope' => 'esi-corporations.read_container_logs.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdContainersLogsGetItem>>
     * @scope esi-corporations.read_container_logs.v1
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/containers/logs', ['corporation_id' => $corporationId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdContainersLogsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
