<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Contracts;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\ContractsPublicRegionIdGetItem;

/**
 * ESI operation: getContractsPublicRegionId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetContractsPublicRegionId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 1800, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<ContractsPublicRegionIdGetItem>>
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $regionId, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/contracts/public/{region_id}', ['region_id' => $regionId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => ContractsPublicRegionIdGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
