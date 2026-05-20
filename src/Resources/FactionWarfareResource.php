<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\FactionWarfare\GetCharactersCharacterIdFwStats;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFwStatsGet;
use Seatplus\EsiSchema\Resources\FactionWarfare\GetCorporationsCorporationIdFwStats;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdFwStatsGet;
use Seatplus\EsiSchema\Resources\FactionWarfare\GetFwLeaderboards;
use Seatplus\EsiSchema\Responses\FwLeaderboardsGet;
use Seatplus\EsiSchema\Resources\FactionWarfare\GetFwLeaderboardsCharacters;
use Seatplus\EsiSchema\Responses\FwLeaderboardsCharactersGet;
use Seatplus\EsiSchema\Resources\FactionWarfare\GetFwLeaderboardsCorporations;
use Seatplus\EsiSchema\Responses\FwLeaderboardsCorporationsGet;
use Seatplus\EsiSchema\Resources\FactionWarfare\GetFwStats;
use Seatplus\EsiSchema\Resources\FactionWarfare\GetFwSystems;
use Seatplus\EsiSchema\Resources\FactionWarfare\GetFwWars;

/**
 * ESI FactionWarfare resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FactionWarfareResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return CharactersCharacterIdFwStatsGet
     * @scope esi-characters.read_fw_stats.v1
     */
    public function getCharactersCharacterIdFwStats(int $characterId): CharactersCharacterIdFwStatsGet
    {
        return GetCharactersCharacterIdFwStats::execute($this->transport, $characterId);
    }

    /**
     * @return CorporationsCorporationIdFwStatsGet
     * @scope esi-corporations.read_fw_stats.v1
     */
    public function getCorporationsCorporationIdFwStats(int $corporationId): CorporationsCorporationIdFwStatsGet
    {
        return GetCorporationsCorporationIdFwStats::execute($this->transport, $corporationId);
    }

    /**
     * @return FwLeaderboardsGet
     */
    public function getFwLeaderboards(): FwLeaderboardsGet
    {
        return GetFwLeaderboards::execute($this->transport);
    }

    /**
     * @return FwLeaderboardsCharactersGet
     */
    public function getFwLeaderboardsCharacters(): FwLeaderboardsCharactersGet
    {
        return GetFwLeaderboardsCharacters::execute($this->transport);
    }

    /**
     * @return FwLeaderboardsCorporationsGet
     */
    public function getFwLeaderboardsCorporations(): FwLeaderboardsCorporationsGet
    {
        return GetFwLeaderboardsCorporations::execute($this->transport);
    }

    /**
     * @return EsiResult
     */
    public function getFwStats(): EsiResult
    {
        return GetFwStats::execute($this->transport);
    }

    /**
     * @return EsiResult
     */
    public function getFwSystems(): EsiResult
    {
        return GetFwSystems::execute($this->transport);
    }

    /**
     * @return EsiResult
     */
    public function getFwWars(): EsiResult
    {
        return GetFwWars::execute($this->transport);
    }
}
