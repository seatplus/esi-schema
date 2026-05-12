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
    protected const array OPERATION_META = [
        'getUniverseAncestries' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseAsteroidBeltsAsteroidBeltId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseBloodlines' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseCategories' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseCategoriesCategoryId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseConstellations' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseConstellationsConstellationId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseFactions' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseGraphics' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseGraphicsGraphicId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseGroups' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseGroupsGroupId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'postUniverseIds' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseMoonsMoonId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'postUniverseNames' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniversePlanetsPlanetId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseRaces' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseRegions' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseRegionsRegionId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseStargatesStargateId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseStarsStarId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseStationsStationId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseStructures' => ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseStructuresStructureId' => ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseSystemJumps' => ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseSystemKills' => ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseSystems' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseSystemsSystemId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseTypes' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getUniverseTypesTypeId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
    ];

    /**
     * @return EsiResult<array<UniverseAncestriesGetItem>>
     */
    public function getUniverseAncestries(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/ancestries', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseAncestriesGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getUniverseAncestries'] ?? null);
    }

    /**
     * @return UniverseAsteroidBeltsAsteroidBeltIdGet
     */
    public function getUniverseAsteroidBeltsAsteroidBeltId(int $asteroidBeltId): UniverseAsteroidBeltsAsteroidBeltIdGet
    {
        $response = $this->transport->invoke('get', '/universe/asteroid_belts/{asteroid_belt_id}', ['asteroid_belt_id' => $asteroidBeltId], []);
        $dto = UniverseAsteroidBeltsAsteroidBeltIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseAsteroidBeltsAsteroidBeltId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseBloodlinesGetItem>>
     */
    public function getUniverseBloodlines(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/bloodlines', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseBloodlinesGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getUniverseBloodlines'] ?? null);
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseCategories(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/categories', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getUniverseCategories'] ?? null);
    }

    /**
     * @return UniverseCategoriesCategoryIdGet
     */
    public function getUniverseCategoriesCategoryId(int $categoryId): UniverseCategoriesCategoryIdGet
    {
        $response = $this->transport->invoke('get', '/universe/categories/{category_id}', ['category_id' => $categoryId], []);
        $dto = UniverseCategoriesCategoryIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseCategoriesCategoryId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseConstellations(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/constellations', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getUniverseConstellations'] ?? null);
    }

    /**
     * @return UniverseConstellationsConstellationIdGet
     */
    public function getUniverseConstellationsConstellationId(int $constellationId): UniverseConstellationsConstellationIdGet
    {
        $response = $this->transport->invoke('get', '/universe/constellations/{constellation_id}', ['constellation_id' => $constellationId], []);
        $dto = UniverseConstellationsConstellationIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseConstellationsConstellationId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseFactionsGetItem>>
     */
    public function getUniverseFactions(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/factions', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseFactionsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getUniverseFactions'] ?? null);
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseGraphics(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/graphics', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getUniverseGraphics'] ?? null);
    }

    /**
     * @return UniverseGraphicsGraphicIdGet
     */
    public function getUniverseGraphicsGraphicId(int $graphicId): UniverseGraphicsGraphicIdGet
    {
        $response = $this->transport->invoke('get', '/universe/graphics/{graphic_id}', ['graphic_id' => $graphicId], []);
        $dto = UniverseGraphicsGraphicIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseGraphicsGraphicId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     * @paginated Use $page param to iterate pages.
     */
    public function getUniverseGroups(int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/groups', [], ['page' => $page]);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getUniverseGroups'] ?? null);
    }

    /**
     * @return UniverseGroupsGroupIdGet
     */
    public function getUniverseGroupsGroupId(int $groupId): UniverseGroupsGroupIdGet
    {
        $response = $this->transport->invoke('get', '/universe/groups/{group_id}', ['group_id' => $groupId], []);
        $dto = UniverseGroupsGroupIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseGroupsGroupId'] ?? null;
        return $dto;
    }

    /**
     * @return UniverseIdsPost
     */
    public function postUniverseIds(mixed $requestBody): UniverseIdsPost
    {
        $response = $this->transport->invoke('post', '/universe/ids', [], [], (array) $requestBody);
        $dto = UniverseIdsPost::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['postUniverseIds'] ?? null;
        return $dto;
    }

    /**
     * @return UniverseMoonsMoonIdGet
     */
    public function getUniverseMoonsMoonId(int $moonId): UniverseMoonsMoonIdGet
    {
        $response = $this->transport->invoke('get', '/universe/moons/{moon_id}', ['moon_id' => $moonId], []);
        $dto = UniverseMoonsMoonIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseMoonsMoonId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseNamesPostItem>>
     */
    public function postUniverseNames(mixed $requestBody): EsiResult
    {
        $response = $this->transport->invoke('post', '/universe/names', [], [], (array) $requestBody);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseNamesPostItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['postUniverseNames'] ?? null);
    }

    /**
     * @return UniversePlanetsPlanetIdGet
     */
    public function getUniversePlanetsPlanetId(int $planetId): UniversePlanetsPlanetIdGet
    {
        $response = $this->transport->invoke('get', '/universe/planets/{planet_id}', ['planet_id' => $planetId], []);
        $dto = UniversePlanetsPlanetIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniversePlanetsPlanetId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseRacesGetItem>>
     */
    public function getUniverseRaces(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/races', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseRacesGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getUniverseRaces'] ?? null);
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseRegions(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/regions', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getUniverseRegions'] ?? null);
    }

    /**
     * @return UniverseRegionsRegionIdGet
     */
    public function getUniverseRegionsRegionId(int $regionId): UniverseRegionsRegionIdGet
    {
        $response = $this->transport->invoke('get', '/universe/regions/{region_id}', ['region_id' => $regionId], []);
        $dto = UniverseRegionsRegionIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseRegionsRegionId'] ?? null;
        return $dto;
    }

    /**
     * @return UniverseStargatesStargateIdGet
     */
    public function getUniverseStargatesStargateId(int $stargateId): UniverseStargatesStargateIdGet
    {
        $response = $this->transport->invoke('get', '/universe/stargates/{stargate_id}', ['stargate_id' => $stargateId], []);
        $dto = UniverseStargatesStargateIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseStargatesStargateId'] ?? null;
        return $dto;
    }

    /**
     * @return UniverseStarsStarIdGet
     */
    public function getUniverseStarsStarId(int $starId): UniverseStarsStarIdGet
    {
        $response = $this->transport->invoke('get', '/universe/stars/{star_id}', ['star_id' => $starId], []);
        $dto = UniverseStarsStarIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseStarsStarId'] ?? null;
        return $dto;
    }

    /**
     * @return UniverseStationsStationIdGet
     */
    public function getUniverseStationsStationId(int $stationId): UniverseStationsStationIdGet
    {
        $response = $this->transport->invoke('get', '/universe/stations/{station_id}', ['station_id' => $stationId], []);
        $dto = UniverseStationsStationIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseStationsStationId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseStructures(?string $filter = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/structures', [], ['filter' => $filter]);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getUniverseStructures'] ?? null);
    }

    /**
     * @return UniverseStructuresStructureIdGet
     * @scope esi-universe.read_structures.v1
     */
    public function getUniverseStructuresStructureId(int $structureId): UniverseStructuresStructureIdGet
    {
        $response = $this->transport->invoke('get', '/universe/structures/{structure_id}', ['structure_id' => $structureId], []);
        $dto = UniverseStructuresStructureIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseStructuresStructureId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseSystemJumpsGetItem>>
     */
    public function getUniverseSystemJumps(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/system_jumps', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseSystemJumpsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getUniverseSystemJumps'] ?? null);
    }

    /**
     * @return EsiResult<array<UniverseSystemKillsGetItem>>
     */
    public function getUniverseSystemKills(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/system_kills', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseSystemKillsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getUniverseSystemKills'] ?? null);
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseSystems(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/systems', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getUniverseSystems'] ?? null);
    }

    /**
     * @return UniverseSystemsSystemIdGet
     */
    public function getUniverseSystemsSystemId(int $systemId): UniverseSystemsSystemIdGet
    {
        $response = $this->transport->invoke('get', '/universe/systems/{system_id}', ['system_id' => $systemId], []);
        $dto = UniverseSystemsSystemIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseSystemsSystemId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     * @paginated Use $page param to iterate pages.
     */
    public function getUniverseTypes(int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/types', [], ['page' => $page]);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getUniverseTypes'] ?? null);
    }

    /**
     * @return UniverseTypesTypeIdGet
     */
    public function getUniverseTypesTypeId(int $typeId): UniverseTypesTypeIdGet
    {
        $response = $this->transport->invoke('get', '/universe/types/{type_id}', ['type_id' => $typeId], []);
        $dto = UniverseTypesTypeIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getUniverseTypesTypeId'] ?? null;
        return $dto;
    }
}
