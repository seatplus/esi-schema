<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFwStatsGet;

/**
 * ESI operation: getCharactersCharacterIdFwStats
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdFwStats implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => ['group' => 'factional-warfare', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-characters.read_fw_stats.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CharactersCharacterIdFwStatsGet
     * @scope esi-characters.read_fw_stats.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId): CharactersCharacterIdFwStatsGet
    {
        $response = $transport->invoke('get', '/characters/{character_id}/fw/stats', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdFwStatsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
