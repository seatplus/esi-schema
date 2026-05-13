<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\WarsWarIdGet;

/**
 * ESI operation: getWarsWarId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetWarsWarId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'killmail', 'max-tokens' => 3600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return WarsWarIdGet
     */
    public static function execute(EsiTransportInterface $transport, int $warId): WarsWarIdGet
    {
        $response = $transport->invoke('get', '/wars/{war_id}', ['war_id' => $warId], []);
        $dto = WarsWarIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
