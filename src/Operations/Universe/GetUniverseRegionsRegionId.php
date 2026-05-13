<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Universe;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\UniverseRegionsRegionIdGet;

/**
 * ESI operation: getUniverseRegionsRegionId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetUniverseRegionsRegionId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return UniverseRegionsRegionIdGet
     */
    public static function execute(EsiTransportInterface $transport, int $regionId): UniverseRegionsRegionIdGet
    {
        $response = $transport->invoke('get', '/universe/regions/{region_id}', ['region_id' => $regionId], []);
        $dto = UniverseRegionsRegionIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
