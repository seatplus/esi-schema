<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Alliance;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\AlliancesAllianceIdIconsGet;

/**
 * ESI operation: getAlliancesAllianceIdIcons
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetAlliancesAllianceIdIcons implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return AlliancesAllianceIdIconsGet
     */
    public static function execute(EsiTransportInterface $transport, int $allianceId): AlliancesAllianceIdIconsGet
    {
        $response = $transport->invoke('get', '/alliances/{alliance_id}/icons', ['alliance_id' => $allianceId], []);
        $dto = AlliancesAllianceIdIconsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
