<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Fleets;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFleetGet;

/**
 * ESI operation: getCharactersCharacterIdFleet
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdFleet implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 60, 'rateLimit' => ['group' => 'fleet', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-fleets.read_fleet.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CharactersCharacterIdFleetGet
     * @scope esi-fleets.read_fleet.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId): CharactersCharacterIdFleetGet
    {
        $response = $transport->invoke('get', '/characters/{character_id}/fleet', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdFleetGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
