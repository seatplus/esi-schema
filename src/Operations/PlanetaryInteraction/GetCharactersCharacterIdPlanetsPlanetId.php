<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\PlanetaryInteraction;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdPlanetsPlanetIdGet;

/**
 * ESI operation: getCharactersCharacterIdPlanetsPlanetId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdPlanetsPlanetId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 600, 'rateLimit' => ['group' => 'char-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-planets.manage_planets.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CharactersCharacterIdPlanetsPlanetIdGet
     * @scope esi-planets.manage_planets.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, int $planetId): CharactersCharacterIdPlanetsPlanetIdGet
    {
        $response = $transport->invoke('get', '/characters/{character_id}/planets/{planet_id}', ['character_id' => $characterId, 'planet_id' => $planetId], []);
        $dto = CharactersCharacterIdPlanetsPlanetIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
