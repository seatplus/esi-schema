<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\UniverseAncestriesGetItem;
use Seatplus\EsiSchema\Responses\UniverseAsteroidBeltsAsteroidBeltIdGet;
use Seatplus\EsiSchema\Responses\UniverseBloodlinesGetItem;
use Seatplus\EsiSchema\Responses\UniverseCategoriesCategoryIdGet;
use Seatplus\EsiSchema\Responses\UniverseConstellationsConstellationIdGet;
use Seatplus\EsiSchema\Responses\UniverseFactionsGetItem;
use Seatplus\EsiSchema\Responses\UniverseGraphicsGraphicIdGet;
use Seatplus\EsiSchema\Responses\UniverseGroupsGroupIdGet;
use Seatplus\EsiSchema\Responses\UniverseIdsPost;
use Seatplus\EsiSchema\Responses\UniverseMoonsMoonIdGet;
use Seatplus\EsiSchema\Responses\UniverseNamesPostItem;
use Seatplus\EsiSchema\Responses\UniversePlanetsPlanetIdGet;
use Seatplus\EsiSchema\Responses\UniverseRacesGetItem;
use Seatplus\EsiSchema\Responses\UniverseRegionsRegionIdGet;
use Seatplus\EsiSchema\Responses\UniverseStargatesStargateIdGet;
use Seatplus\EsiSchema\Responses\UniverseStarsStarIdGet;
use Seatplus\EsiSchema\Responses\UniverseStationsStationIdGet;
use Seatplus\EsiSchema\Responses\UniverseStructuresStructureIdGet;
use Seatplus\EsiSchema\Responses\UniverseSystemJumpsGetItem;
use Seatplus\EsiSchema\Responses\UniverseSystemKillsGetItem;
use Seatplus\EsiSchema\Responses\UniverseSystemsSystemIdGet;
use Seatplus\EsiSchema\Responses\UniverseTypesTypeIdGet;

/**
 * ESI tag: Universe
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class UniverseResource extends AbstractResource
{
    /**
     * @return EsiResult<array<UniverseAncestriesGetItem>>
     */
    public function getUniverseAncestries(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/ancestries', [], 'latest', []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseAncestriesGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return UniverseAsteroidBeltsAsteroidBeltIdGet
     */
    public function getUniverseAsteroidBeltsAsteroidBeltId(int $asteroidBeltId): UniverseAsteroidBeltsAsteroidBeltIdGet
    {
        $response = $this->transport->invoke('get', '/universe/asteroid_belts/{asteroid_belt_id}', ['asteroid_belt_id' => $asteroidBeltId], 'latest', []);
        $dto = UniverseAsteroidBeltsAsteroidBeltIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseBloodlinesGetItem>>
     */
    public function getUniverseBloodlines(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/bloodlines', [], 'latest', []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseBloodlinesGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseCategories(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/categories', [], 'latest', []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return UniverseCategoriesCategoryIdGet
     */
    public function getUniverseCategoriesCategoryId(int $categoryId): UniverseCategoriesCategoryIdGet
    {
        $response = $this->transport->invoke('get', '/universe/categories/{category_id}', ['category_id' => $categoryId], 'latest', []);
        $dto = UniverseCategoriesCategoryIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseConstellations(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/constellations', [], 'latest', []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return UniverseConstellationsConstellationIdGet
     */
    public function getUniverseConstellationsConstellationId(int $constellationId): UniverseConstellationsConstellationIdGet
    {
        $response = $this->transport->invoke('get', '/universe/constellations/{constellation_id}', ['constellation_id' => $constellationId], 'latest', []);
        $dto = UniverseConstellationsConstellationIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseFactionsGetItem>>
     */
    public function getUniverseFactions(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/factions', [], 'latest', []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseFactionsGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseGraphics(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/graphics', [], 'latest', []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return UniverseGraphicsGraphicIdGet
     */
    public function getUniverseGraphicsGraphicId(int $graphicId): UniverseGraphicsGraphicIdGet
    {
        $response = $this->transport->invoke('get', '/universe/graphics/{graphic_id}', ['graphic_id' => $graphicId], 'latest', []);
        $dto = UniverseGraphicsGraphicIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     * @paginated Use $page param to iterate pages.
     */
    public function getUniverseGroups(int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/groups', [], 'latest', ['page' => $page]);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return UniverseGroupsGroupIdGet
     */
    public function getUniverseGroupsGroupId(int $groupId): UniverseGroupsGroupIdGet
    {
        $response = $this->transport->invoke('get', '/universe/groups/{group_id}', ['group_id' => $groupId], 'latest', []);
        $dto = UniverseGroupsGroupIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return UniverseIdsPost
     */
    public function postUniverseIds(mixed $requestBody): UniverseIdsPost
    {
        $response = $this->transport->invoke('post', '/universe/ids', [], 'latest', [], (array) $requestBody);
        $dto = UniverseIdsPost::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return UniverseMoonsMoonIdGet
     */
    public function getUniverseMoonsMoonId(int $moonId): UniverseMoonsMoonIdGet
    {
        $response = $this->transport->invoke('get', '/universe/moons/{moon_id}', ['moon_id' => $moonId], 'latest', []);
        $dto = UniverseMoonsMoonIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseNamesPostItem>>
     */
    public function postUniverseNames(mixed $requestBody): EsiResult
    {
        $response = $this->transport->invoke('post', '/universe/names', [], 'latest', [], (array) $requestBody);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseNamesPostItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return UniversePlanetsPlanetIdGet
     */
    public function getUniversePlanetsPlanetId(int $planetId): UniversePlanetsPlanetIdGet
    {
        $response = $this->transport->invoke('get', '/universe/planets/{planet_id}', ['planet_id' => $planetId], 'latest', []);
        $dto = UniversePlanetsPlanetIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseRacesGetItem>>
     */
    public function getUniverseRaces(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/races', [], 'latest', []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseRacesGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseRegions(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/regions', [], 'latest', []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return UniverseRegionsRegionIdGet
     */
    public function getUniverseRegionsRegionId(int $regionId): UniverseRegionsRegionIdGet
    {
        $response = $this->transport->invoke('get', '/universe/regions/{region_id}', ['region_id' => $regionId], 'latest', []);
        $dto = UniverseRegionsRegionIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return UniverseStargatesStargateIdGet
     */
    public function getUniverseStargatesStargateId(int $stargateId): UniverseStargatesStargateIdGet
    {
        $response = $this->transport->invoke('get', '/universe/stargates/{stargate_id}', ['stargate_id' => $stargateId], 'latest', []);
        $dto = UniverseStargatesStargateIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return UniverseStarsStarIdGet
     */
    public function getUniverseStarsStarId(int $starId): UniverseStarsStarIdGet
    {
        $response = $this->transport->invoke('get', '/universe/stars/{star_id}', ['star_id' => $starId], 'latest', []);
        $dto = UniverseStarsStarIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return UniverseStationsStationIdGet
     */
    public function getUniverseStationsStationId(int $stationId): UniverseStationsStationIdGet
    {
        $response = $this->transport->invoke('get', '/universe/stations/{station_id}', ['station_id' => $stationId], 'latest', []);
        $dto = UniverseStationsStationIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseStructures(?string $filter = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/structures', [], 'latest', ['filter' => $filter]);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return UniverseStructuresStructureIdGet
     * @scope esi-universe.read_structures.v1
     */
    public function getUniverseStructuresStructureId(int $structureId): UniverseStructuresStructureIdGet
    {
        $response = $this->transport->invoke('get', '/universe/structures/{structure_id}', ['structure_id' => $structureId], 'latest', []);
        $dto = UniverseStructuresStructureIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseSystemJumpsGetItem>>
     */
    public function getUniverseSystemJumps(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/system_jumps', [], 'latest', []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseSystemJumpsGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<UniverseSystemKillsGetItem>>
     */
    public function getUniverseSystemKills(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/system_kills', [], 'latest', []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseSystemKillsGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseSystems(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/systems', [], 'latest', []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return UniverseSystemsSystemIdGet
     */
    public function getUniverseSystemsSystemId(int $systemId): UniverseSystemsSystemIdGet
    {
        $response = $this->transport->invoke('get', '/universe/systems/{system_id}', ['system_id' => $systemId], 'latest', []);
        $dto = UniverseSystemsSystemIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     * @paginated Use $page param to iterate pages.
     */
    public function getUniverseTypes(int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/types', [], 'latest', ['page' => $page]);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return UniverseTypesTypeIdGet
     */
    public function getUniverseTypesTypeId(int $typeId): UniverseTypesTypeIdGet
    {
        $response = $this->transport->invoke('get', '/universe/types/{type_id}', ['type_id' => $typeId], 'latest', []);
        $dto = UniverseTypesTypeIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }
}
