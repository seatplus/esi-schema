<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Market;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdOrdersGetItem;

/**
 * ESI operation: getCorporationsCorporationIdOrders
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdOrders implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 1200, 'rateLimit' => null, 'requiredRoles' => ['Accountant', 'Trader'], 'cursor' => false, 'requiredScope' => 'esi-markets.read_corporation_orders.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdOrdersGetItem>>
     * @scope esi-markets.read_corporation_orders.v1
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/orders', ['corporation_id' => $corporationId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdOrdersGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
