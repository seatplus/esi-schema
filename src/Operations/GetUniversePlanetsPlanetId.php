<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\UniversePlanetsPlanetIdGet;

/**
 * ESI operation: getUniversePlanetsPlanetId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetUniversePlanetsPlanetId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return UniversePlanetsPlanetIdGet
     */
    public static function execute(EsiTransportInterface $transport, int $planetId): UniversePlanetsPlanetIdGet
    {
        $response = $transport->invoke('get', '/universe/planets/{planet_id}', ['planet_id' => $planetId], []);
        $dto = UniversePlanetsPlanetIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
