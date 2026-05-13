<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdLocationGet;

/**
 * ESI operation: getCharactersCharacterIdLocation
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdLocation implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 5, 'rateLimit' => ['group' => 'char-location', 'max-tokens' => 1200, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-location.read_location.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CharactersCharacterIdLocationGet
     * @scope esi-location.read_location.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId): CharactersCharacterIdLocationGet
    {
        $response = $transport->invoke('get', '/characters/{character_id}/location', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdLocationGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
