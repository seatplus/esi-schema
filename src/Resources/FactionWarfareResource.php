<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFwStatsGet;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdFwStatsGet;
use Seatplus\EsiSchema\Responses\FwLeaderboardsGet;
use Seatplus\EsiSchema\Responses\FwLeaderboardsCharactersGet;
use Seatplus\EsiSchema\Responses\FwLeaderboardsCorporationsGet;
use Seatplus\EsiSchema\Responses\FwStatsGetItem;
use Seatplus\EsiSchema\Responses\FwSystemsGetItem;
use Seatplus\EsiSchema\Responses\FwWarsGetItem;

/**
 * ESI tag: FactionWarfare
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class FactionWarfareResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCharactersCharacterIdFwStats' => ['cacheAge' => null, 'rateLimit' => ['group' => 'factional-warfare', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCorporationsCorporationIdFwStats' => ['cacheAge' => null, 'rateLimit' => ['group' => 'factional-warfare', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getFwLeaderboards' => ['cacheAge' => null, 'rateLimit' => ['group' => 'factional-warfare', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getFwLeaderboardsCharacters' => ['cacheAge' => null, 'rateLimit' => ['group' => 'factional-warfare', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getFwLeaderboardsCorporations' => ['cacheAge' => null, 'rateLimit' => ['group' => 'factional-warfare', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getFwStats' => ['cacheAge' => null, 'rateLimit' => ['group' => 'factional-warfare', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getFwSystems' => ['cacheAge' => 1800, 'rateLimit' => ['group' => 'factional-warfare', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getFwWars' => ['cacheAge' => null, 'rateLimit' => ['group' => 'factional-warfare', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
    ];

    /**
     * @return CharactersCharacterIdFwStatsGet
     * @scope esi-characters.read_fw_stats.v1
     */
    public function getCharactersCharacterIdFwStats(int $characterId): CharactersCharacterIdFwStatsGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/fw/stats', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdFwStatsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return CorporationsCorporationIdFwStatsGet
     * @scope esi-corporations.read_fw_stats.v1
     */
    public function getCorporationsCorporationIdFwStats(int $corporationId): CorporationsCorporationIdFwStatsGet
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/fw/stats', ['corporation_id' => $corporationId], []);
        $dto = CorporationsCorporationIdFwStatsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return FwLeaderboardsGet
     */
    public function getFwLeaderboards(): FwLeaderboardsGet
    {
        $response = $this->transport->invoke('get', '/fw/leaderboards', [], []);
        $dto = FwLeaderboardsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return FwLeaderboardsCharactersGet
     */
    public function getFwLeaderboardsCharacters(): FwLeaderboardsCharactersGet
    {
        $response = $this->transport->invoke('get', '/fw/leaderboards/characters', [], []);
        $dto = FwLeaderboardsCharactersGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return FwLeaderboardsCorporationsGet
     */
    public function getFwLeaderboardsCorporations(): FwLeaderboardsCorporationsGet
    {
        $response = $this->transport->invoke('get', '/fw/leaderboards/corporations', [], []);
        $dto = FwLeaderboardsCorporationsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<FwStatsGetItem>>
     */
    public function getFwStats(): EsiResult
    {
        $response = $this->transport->invoke('get', '/fw/stats', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => FwStatsGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<FwSystemsGetItem>>
     */
    public function getFwSystems(): EsiResult
    {
        $response = $this->transport->invoke('get', '/fw/systems', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => FwSystemsGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<FwWarsGetItem>>
     */
    public function getFwWars(): EsiResult
    {
        $response = $this->transport->invoke('get', '/fw/wars', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => FwWarsGetItem::from($item),
            (array) $response->data,
        ));
    }
}
