<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\MarketsRegionIdHistoryGetItem;

/**
 * ESI operation: getMarketsRegionIdHistory
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetMarketsRegionIdHistory implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<MarketsRegionIdHistoryGetItem>>
     */
    public static function execute(EsiTransportInterface $transport, int $regionId, int $typeId): EsiResult
    {
        $response = $transport->invoke('get', '/markets/{region_id}/history', ['region_id' => $regionId], ['type_id' => $typeId]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => MarketsRegionIdHistoryGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
