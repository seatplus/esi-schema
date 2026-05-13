<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Corporation;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdStarbasesStarbaseIdGet;

/**
 * ESI operation: getCorporationsCorporationIdStarbasesStarbaseId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdStarbasesStarbaseId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => ['Director'], 'cursor' => false, 'requiredScope' => 'esi-corporations.read_starbases.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CorporationsCorporationIdStarbasesStarbaseIdGet
     * @scope esi-corporations.read_starbases.v1
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, int $starbaseId, int $systemId): CorporationsCorporationIdStarbasesStarbaseIdGet
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/starbases/{starbase_id}', ['corporation_id' => $corporationId, 'starbase_id' => $starbaseId], ['system_id' => $systemId]);
        $dto = CorporationsCorporationIdStarbasesStarbaseIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
