<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Market;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\MarketsRegionIdOrdersGetItem;

/**
 * ESI operation: getMarketsRegionIdOrders
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetMarketsRegionIdOrders implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 300, 'rateLimit' => ['group' => 'market-order', 'max-tokens' => 12000, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<MarketsRegionIdOrdersGetItem>>
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, string $orderType, int $regionId, int $page = 1, ?int $typeId = null): EsiResult
    {
        $response = $transport->invoke('get', '/markets/{region_id}/orders', ['region_id' => $regionId], ['order_type' => $orderType, 'page' => $page, 'type_id' => $typeId]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => MarketsRegionIdOrdersGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
