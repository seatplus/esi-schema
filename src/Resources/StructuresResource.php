<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\Resources\Structures\GetCharactersStructuresMercenaryDensListing;
use Seatplus\EsiSchema\Responses\CharactersStructuresMercenaryDensListing;
use Seatplus\EsiSchema\Resources\Structures\GetCharactersStructuresMercenaryDensDetail;
use Seatplus\EsiSchema\Responses\CharactersStructuresMercenaryDensDetail;
use Seatplus\EsiSchema\Resources\Structures\GetCorporationsStructuresSkyhooksListing;
use Seatplus\EsiSchema\Responses\CorporationsStructuresSkyhooksListing;
use Seatplus\EsiSchema\Resources\Structures\GetCorporationsStructuresSkyhooksDetail;
use Seatplus\EsiSchema\Responses\CorporationsStructuresSkyhooksDetail;
use Seatplus\EsiSchema\Resources\Structures\GetCorporationsStructuresSovereigntyHubsListing;
use Seatplus\EsiSchema\Responses\CorporationsStructuresSovereigntyHubsListing;
use Seatplus\EsiSchema\Resources\Structures\GetCorporationsStructuresSovereigntyHubsDetail;
use Seatplus\EsiSchema\Responses\CorporationsStructuresSovereigntyHubsDetail;

/**
 * ESI Structures resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class StructuresResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return CharactersStructuresMercenaryDensListing
     * @scope esi-structures.read_character.v1
     */
    public function getCharactersStructuresMercenaryDensListing(int $characterId): CharactersStructuresMercenaryDensListing
    {
        return GetCharactersStructuresMercenaryDensListing::execute($this->transport, $characterId);
    }

    /**
     * @return CharactersStructuresMercenaryDensDetail
     * @scope esi-structures.read_character.v1
     */
    public function getCharactersStructuresMercenaryDensDetail(int $mercenaryDenId, int $characterId): CharactersStructuresMercenaryDensDetail
    {
        return GetCharactersStructuresMercenaryDensDetail::execute($this->transport, $mercenaryDenId, $characterId);
    }

    /**
     * @return CorporationsStructuresSkyhooksListing
     * @scope esi-structures.read_corporation.v1
     */
    public function getCorporationsStructuresSkyhooksListing(int $corporationId): CorporationsStructuresSkyhooksListing
    {
        return GetCorporationsStructuresSkyhooksListing::execute($this->transport, $corporationId);
    }

    /**
     * @return CorporationsStructuresSkyhooksDetail
     * @scope esi-structures.read_corporation.v1
     */
    public function getCorporationsStructuresSkyhooksDetail(int $skyhookId, int $corporationId): CorporationsStructuresSkyhooksDetail
    {
        return GetCorporationsStructuresSkyhooksDetail::execute($this->transport, $skyhookId, $corporationId);
    }

    /**
     * @return CorporationsStructuresSovereigntyHubsListing
     * @scope esi-structures.read_corporation.v1
     */
    public function getCorporationsStructuresSovereigntyHubsListing(int $corporationId): CorporationsStructuresSovereigntyHubsListing
    {
        return GetCorporationsStructuresSovereigntyHubsListing::execute($this->transport, $corporationId);
    }

    /**
     * @return CorporationsStructuresSovereigntyHubsDetail
     * @scope esi-structures.read_corporation.v1
     */
    public function getCorporationsStructuresSovereigntyHubsDetail(int $sovereigntyHubId, int $corporationId): CorporationsStructuresSovereigntyHubsDetail
    {
        return GetCorporationsStructuresSovereigntyHubsDetail::execute($this->transport, $sovereigntyHubId, $corporationId);
    }
}
