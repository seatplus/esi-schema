<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdPlanetsGetItem;
use Seatplus\EsiSchema\Operations\PlanetaryInteraction\GetCharactersCharacterIdPlanets;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdPlanetsPlanetIdGet;
use Seatplus\EsiSchema\Operations\PlanetaryInteraction\GetCharactersCharacterIdPlanetsPlanetId;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdCustomsOfficesGetItem;
use Seatplus\EsiSchema\Operations\PlanetaryInteraction\GetCorporationsCorporationIdCustomsOffices;
use Seatplus\EsiSchema\Responses\UniverseSchematicsSchematicIdGet;
use Seatplus\EsiSchema\Operations\PlanetaryInteraction\GetUniverseSchematicsSchematicId;

/**
 * ESI tag: PlanetaryInteraction
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class PlanetaryInteractionResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdPlanets' => GetCharactersCharacterIdPlanets::meta(),
            'getCharactersCharacterIdPlanetsPlanetId' => GetCharactersCharacterIdPlanetsPlanetId::meta(),
            'getCorporationsCorporationIdCustomsOffices' => GetCorporationsCorporationIdCustomsOffices::meta(),
            'getUniverseSchematicsSchematicId' => GetUniverseSchematicsSchematicId::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdPlanets. Equivalent to GetCharactersCharacterIdPlanets::meta(). */
    public static function getCharactersCharacterIdPlanetsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdPlanets::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdPlanetsPlanetId. Equivalent to GetCharactersCharacterIdPlanetsPlanetId::meta(). */
    public static function getCharactersCharacterIdPlanetsPlanetIdMeta(): OperationMeta
    {
        return GetCharactersCharacterIdPlanetsPlanetId::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdCustomsOffices. Equivalent to GetCorporationsCorporationIdCustomsOffices::meta(). */
    public static function getCorporationsCorporationIdCustomsOfficesMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdCustomsOffices::meta();
    }

    /** Pre-call metadata for getUniverseSchematicsSchematicId. Equivalent to GetUniverseSchematicsSchematicId::meta(). */
    public static function getUniverseSchematicsSchematicIdMeta(): OperationMeta
    {
        return GetUniverseSchematicsSchematicId::meta();
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdPlanetsGetItem>>
     * @scope esi-planets.manage_planets.v1
     */
    public function getCharactersCharacterIdPlanets(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/planets', ['character_id' => $characterId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdPlanetsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdPlanets::meta(),
        );
    }

    /**
     * @return CharactersCharacterIdPlanetsPlanetIdGet
     * @scope esi-planets.manage_planets.v1
     */
    public function getCharactersCharacterIdPlanetsPlanetId(int $characterId, int $planetId): CharactersCharacterIdPlanetsPlanetIdGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/planets/{planet_id}', ['character_id' => $characterId, 'planet_id' => $planetId], []);
        $dto = CharactersCharacterIdPlanetsPlanetIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCharactersCharacterIdPlanetsPlanetId::meta();
        return $dto;
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdCustomsOfficesGetItem>>
     * @scope esi-planets.read_customs_offices.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdCustomsOffices(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/customs_offices', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdCustomsOfficesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdCustomsOffices::meta(),
        );
    }

    /**
     * @return UniverseSchematicsSchematicIdGet
     */
    public function getUniverseSchematicsSchematicId(int $schematicId): UniverseSchematicsSchematicIdGet
    {
        $response = $this->transport->invoke('get', '/universe/schematics/{schematic_id}', ['schematic_id' => $schematicId], []);
        $dto = UniverseSchematicsSchematicIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetUniverseSchematicsSchematicId::meta();
        return $dto;
    }
}
