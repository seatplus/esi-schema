<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\PlanetaryInteraction\GetCharactersCharacterIdPlanets;
use Seatplus\EsiSchema\Resources\PlanetaryInteraction\GetCharactersCharacterIdPlanetsPlanetId;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdPlanetsPlanetIdGet;
use Seatplus\EsiSchema\Resources\PlanetaryInteraction\GetCorporationsCorporationIdCustomsOffices;
use Seatplus\EsiSchema\Resources\PlanetaryInteraction\GetUniverseSchematicsSchematicId;
use Seatplus\EsiSchema\Responses\UniverseSchematicsSchematicIdGet;

/**
 * ESI PlanetaryInteraction resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class PlanetaryInteractionResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     * @scope esi-planets.manage_planets.v1
     */
    public function getCharactersCharacterIdPlanets(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdPlanets::execute($this->transport, $characterId);
    }

    /**
     * @return CharactersCharacterIdPlanetsPlanetIdGet
     * @scope esi-planets.manage_planets.v1
     */
    public function getCharactersCharacterIdPlanetsPlanetId(int $characterId, int $planetId): CharactersCharacterIdPlanetsPlanetIdGet
    {
        return GetCharactersCharacterIdPlanetsPlanetId::execute($this->transport, $characterId, $planetId);
    }

    /**
     * @return EsiResult
     * @scope esi-planets.read_customs_offices.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdCustomsOffices(int $corporationId, int $page = 1): EsiResult
    {
        return GetCorporationsCorporationIdCustomsOffices::execute($this->transport, $corporationId, $page);
    }

    /**
     * @return UniverseSchematicsSchematicIdGet
     */
    public function getUniverseSchematicsSchematicId(int $schematicId): UniverseSchematicsSchematicIdGet
    {
        return GetUniverseSchematicsSchematicId::execute($this->transport, $schematicId);
    }
}
