<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Location;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdOnlineGet;

/**
 * ESI operation: getCharactersCharacterIdOnline
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdOnline implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 60, 'rateLimit' => ['group' => 'char-location', 'max-tokens' => 1200, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-location.read_online.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CharactersCharacterIdOnlineGet
     * @scope esi-location.read_online.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId): CharactersCharacterIdOnlineGet
    {
        $response = $transport->invoke('get', '/characters/{character_id}/online', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdOnlineGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
