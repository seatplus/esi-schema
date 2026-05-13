<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Corporation;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdIconsGet;

/**
 * ESI operation: getCorporationsCorporationIdIcons
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdIcons implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CorporationsCorporationIdIconsGet
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId): CorporationsCorporationIdIconsGet
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/icons', ['corporation_id' => $corporationId], []);
        $dto = CorporationsCorporationIdIconsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
