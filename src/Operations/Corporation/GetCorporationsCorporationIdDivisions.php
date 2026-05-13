<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Corporation;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdDivisionsGet;

/**
 * ESI operation: getCorporationsCorporationIdDivisions
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdDivisions implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'corp-wallet', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => ['Director'], 'cursor' => false, 'requiredScope' => 'esi-corporations.read_divisions.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CorporationsCorporationIdDivisionsGet
     * @scope esi-corporations.read_divisions.v1
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId): CorporationsCorporationIdDivisionsGet
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/divisions', ['corporation_id' => $corporationId], []);
        $dto = CorporationsCorporationIdDivisionsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
