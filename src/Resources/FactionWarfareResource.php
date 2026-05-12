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
    /**
     * @return CharactersCharacterIdFwStatsGet
     * @scope esi-characters.read_fw_stats.v1
     */
    public function getCharactersCharacterIdFwStats(int $characterId): CharactersCharacterIdFwStatsGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/fw/stats', ['character_id' => $characterId], 'latest', []);
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
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/fw/stats', ['corporation_id' => $corporationId], 'latest', []);
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
        $response = $this->transport->invoke('get', '/fw/leaderboards', [], 'latest', []);
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
        $response = $this->transport->invoke('get', '/fw/leaderboards/characters', [], 'latest', []);
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
        $response = $this->transport->invoke('get', '/fw/leaderboards/corporations', [], 'latest', []);
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
        $response = $this->transport->invoke('get', '/fw/stats', [], 'latest', []);
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
        $response = $this->transport->invoke('get', '/fw/systems', [], 'latest', []);
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
        $response = $this->transport->invoke('get', '/fw/wars', [], 'latest', []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => FwWarsGetItem::from($item),
            (array) $response->data,
        ));
    }
}
