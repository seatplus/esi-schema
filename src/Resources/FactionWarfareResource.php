<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFwStatsGet;
use Seatplus\EsiSchema\Operations\FactionWarfare\GetCharactersCharacterIdFwStats;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdFwStatsGet;
use Seatplus\EsiSchema\Operations\FactionWarfare\GetCorporationsCorporationIdFwStats;
use Seatplus\EsiSchema\Responses\FwLeaderboardsGet;
use Seatplus\EsiSchema\Operations\FactionWarfare\GetFwLeaderboards;
use Seatplus\EsiSchema\Responses\FwLeaderboardsCharactersGet;
use Seatplus\EsiSchema\Operations\FactionWarfare\GetFwLeaderboardsCharacters;
use Seatplus\EsiSchema\Responses\FwLeaderboardsCorporationsGet;
use Seatplus\EsiSchema\Operations\FactionWarfare\GetFwLeaderboardsCorporations;
use Seatplus\EsiSchema\Responses\FwStatsGetItem;
use Seatplus\EsiSchema\Operations\FactionWarfare\GetFwStats;
use Seatplus\EsiSchema\Responses\FwSystemsGetItem;
use Seatplus\EsiSchema\Operations\FactionWarfare\GetFwSystems;
use Seatplus\EsiSchema\Responses\FwWarsGetItem;
use Seatplus\EsiSchema\Operations\FactionWarfare\GetFwWars;

/**
 * ESI tag: FactionWarfare
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class FactionWarfareResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdFwStats' => GetCharactersCharacterIdFwStats::meta(),
            'getCorporationsCorporationIdFwStats' => GetCorporationsCorporationIdFwStats::meta(),
            'getFwLeaderboards' => GetFwLeaderboards::meta(),
            'getFwLeaderboardsCharacters' => GetFwLeaderboardsCharacters::meta(),
            'getFwLeaderboardsCorporations' => GetFwLeaderboardsCorporations::meta(),
            'getFwStats' => GetFwStats::meta(),
            'getFwSystems' => GetFwSystems::meta(),
            'getFwWars' => GetFwWars::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdFwStats. Equivalent to GetCharactersCharacterIdFwStats::meta(). */
    public static function getCharactersCharacterIdFwStatsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdFwStats::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdFwStats. Equivalent to GetCorporationsCorporationIdFwStats::meta(). */
    public static function getCorporationsCorporationIdFwStatsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdFwStats::meta();
    }

    /** Pre-call metadata for getFwLeaderboards. Equivalent to GetFwLeaderboards::meta(). */
    public static function getFwLeaderboardsMeta(): OperationMeta
    {
        return GetFwLeaderboards::meta();
    }

    /** Pre-call metadata for getFwLeaderboardsCharacters. Equivalent to GetFwLeaderboardsCharacters::meta(). */
    public static function getFwLeaderboardsCharactersMeta(): OperationMeta
    {
        return GetFwLeaderboardsCharacters::meta();
    }

    /** Pre-call metadata for getFwLeaderboardsCorporations. Equivalent to GetFwLeaderboardsCorporations::meta(). */
    public static function getFwLeaderboardsCorporationsMeta(): OperationMeta
    {
        return GetFwLeaderboardsCorporations::meta();
    }

    /** Pre-call metadata for getFwStats. Equivalent to GetFwStats::meta(). */
    public static function getFwStatsMeta(): OperationMeta
    {
        return GetFwStats::meta();
    }

    /** Pre-call metadata for getFwSystems. Equivalent to GetFwSystems::meta(). */
    public static function getFwSystemsMeta(): OperationMeta
    {
        return GetFwSystems::meta();
    }

    /** Pre-call metadata for getFwWars. Equivalent to GetFwWars::meta(). */
    public static function getFwWarsMeta(): OperationMeta
    {
        return GetFwWars::meta();
    }

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
        $dto->operationMeta = GetCharactersCharacterIdFwStats::meta();
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
        $dto->operationMeta = GetCorporationsCorporationIdFwStats::meta();
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
        $dto->operationMeta = GetFwLeaderboards::meta();
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
        $dto->operationMeta = GetFwLeaderboardsCharacters::meta();
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
        $dto->operationMeta = GetFwLeaderboardsCorporations::meta();
        return $dto;
    }

    /**
     * @return EsiResult<array<FwStatsGetItem>>
     */
    public function getFwStats(): EsiResult
    {
        $response = $this->transport->invoke('get', '/fw/stats', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => FwStatsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetFwStats::meta(),
        );
    }

    /**
     * @return EsiResult<array<FwSystemsGetItem>>
     */
    public function getFwSystems(): EsiResult
    {
        $response = $this->transport->invoke('get', '/fw/systems', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => FwSystemsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetFwSystems::meta(),
        );
    }

    /**
     * @return EsiResult<array<FwWarsGetItem>>
     */
    public function getFwWars(): EsiResult
    {
        $response = $this->transport->invoke('get', '/fw/wars', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => FwWarsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetFwWars::meta(),
        );
    }
}
