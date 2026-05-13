<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\FactionWarfare;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\FwLeaderboardsCorporationsGet;

/**
 * ESI operation: getFwLeaderboardsCorporations
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetFwLeaderboardsCorporations implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => ['group' => 'factional-warfare', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return FwLeaderboardsCorporationsGet
     */
    public static function execute(EsiTransportInterface $transport): FwLeaderboardsCorporationsGet
    {
        $response = $transport->invoke('get', '/fw/leaderboards/corporations', [], []);
        $dto = FwLeaderboardsCorporationsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
