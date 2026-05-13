<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\UniverseAncestriesGetItem;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseAncestries;
use Seatplus\EsiSchema\Responses\UniverseAsteroidBeltsAsteroidBeltIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseAsteroidBeltsAsteroidBeltId;
use Seatplus\EsiSchema\Responses\UniverseBloodlinesGetItem;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseBloodlines;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseCategories;
use Seatplus\EsiSchema\Responses\UniverseCategoriesCategoryIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseCategoriesCategoryId;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseConstellations;
use Seatplus\EsiSchema\Responses\UniverseConstellationsConstellationIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseConstellationsConstellationId;
use Seatplus\EsiSchema\Responses\UniverseFactionsGetItem;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseFactions;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseGraphics;
use Seatplus\EsiSchema\Responses\UniverseGraphicsGraphicIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseGraphicsGraphicId;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseGroups;
use Seatplus\EsiSchema\Responses\UniverseGroupsGroupIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseGroupsGroupId;
use Seatplus\EsiSchema\Responses\UniverseIdsPost;
use Seatplus\EsiSchema\Operations\Universe\PostUniverseIds;
use Seatplus\EsiSchema\Responses\UniverseMoonsMoonIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseMoonsMoonId;
use Seatplus\EsiSchema\Responses\UniverseNamesPostItem;
use Seatplus\EsiSchema\Operations\Universe\PostUniverseNames;
use Seatplus\EsiSchema\Responses\UniversePlanetsPlanetIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniversePlanetsPlanetId;
use Seatplus\EsiSchema\Responses\UniverseRacesGetItem;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseRaces;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseRegions;
use Seatplus\EsiSchema\Responses\UniverseRegionsRegionIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseRegionsRegionId;
use Seatplus\EsiSchema\Responses\UniverseStargatesStargateIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseStargatesStargateId;
use Seatplus\EsiSchema\Responses\UniverseStarsStarIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseStarsStarId;
use Seatplus\EsiSchema\Responses\UniverseStationsStationIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseStationsStationId;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseStructures;
use Seatplus\EsiSchema\Responses\UniverseStructuresStructureIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseStructuresStructureId;
use Seatplus\EsiSchema\Responses\UniverseSystemJumpsGetItem;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseSystemJumps;
use Seatplus\EsiSchema\Responses\UniverseSystemKillsGetItem;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseSystemKills;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseSystems;
use Seatplus\EsiSchema\Responses\UniverseSystemsSystemIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseSystemsSystemId;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseTypes;
use Seatplus\EsiSchema\Responses\UniverseTypesTypeIdGet;
use Seatplus\EsiSchema\Operations\Universe\GetUniverseTypesTypeId;

/**
 * ESI tag: Universe
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class UniverseResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getUniverseAncestries' => GetUniverseAncestries::meta(),
            'getUniverseAsteroidBeltsAsteroidBeltId' => GetUniverseAsteroidBeltsAsteroidBeltId::meta(),
            'getUniverseBloodlines' => GetUniverseBloodlines::meta(),
            'getUniverseCategories' => GetUniverseCategories::meta(),
            'getUniverseCategoriesCategoryId' => GetUniverseCategoriesCategoryId::meta(),
            'getUniverseConstellations' => GetUniverseConstellations::meta(),
            'getUniverseConstellationsConstellationId' => GetUniverseConstellationsConstellationId::meta(),
            'getUniverseFactions' => GetUniverseFactions::meta(),
            'getUniverseGraphics' => GetUniverseGraphics::meta(),
            'getUniverseGraphicsGraphicId' => GetUniverseGraphicsGraphicId::meta(),
            'getUniverseGroups' => GetUniverseGroups::meta(),
            'getUniverseGroupsGroupId' => GetUniverseGroupsGroupId::meta(),
            'postUniverseIds' => PostUniverseIds::meta(),
            'getUniverseMoonsMoonId' => GetUniverseMoonsMoonId::meta(),
            'postUniverseNames' => PostUniverseNames::meta(),
            'getUniversePlanetsPlanetId' => GetUniversePlanetsPlanetId::meta(),
            'getUniverseRaces' => GetUniverseRaces::meta(),
            'getUniverseRegions' => GetUniverseRegions::meta(),
            'getUniverseRegionsRegionId' => GetUniverseRegionsRegionId::meta(),
            'getUniverseStargatesStargateId' => GetUniverseStargatesStargateId::meta(),
            'getUniverseStarsStarId' => GetUniverseStarsStarId::meta(),
            'getUniverseStationsStationId' => GetUniverseStationsStationId::meta(),
            'getUniverseStructures' => GetUniverseStructures::meta(),
            'getUniverseStructuresStructureId' => GetUniverseStructuresStructureId::meta(),
            'getUniverseSystemJumps' => GetUniverseSystemJumps::meta(),
            'getUniverseSystemKills' => GetUniverseSystemKills::meta(),
            'getUniverseSystems' => GetUniverseSystems::meta(),
            'getUniverseSystemsSystemId' => GetUniverseSystemsSystemId::meta(),
            'getUniverseTypes' => GetUniverseTypes::meta(),
            'getUniverseTypesTypeId' => GetUniverseTypesTypeId::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getUniverseAncestries. Equivalent to GetUniverseAncestries::meta(). */
    public static function getUniverseAncestriesMeta(): OperationMeta
    {
        return GetUniverseAncestries::meta();
    }

    /** Pre-call metadata for getUniverseAsteroidBeltsAsteroidBeltId. Equivalent to GetUniverseAsteroidBeltsAsteroidBeltId::meta(). */
    public static function getUniverseAsteroidBeltsAsteroidBeltIdMeta(): OperationMeta
    {
        return GetUniverseAsteroidBeltsAsteroidBeltId::meta();
    }

    /** Pre-call metadata for getUniverseBloodlines. Equivalent to GetUniverseBloodlines::meta(). */
    public static function getUniverseBloodlinesMeta(): OperationMeta
    {
        return GetUniverseBloodlines::meta();
    }

    /** Pre-call metadata for getUniverseCategories. Equivalent to GetUniverseCategories::meta(). */
    public static function getUniverseCategoriesMeta(): OperationMeta
    {
        return GetUniverseCategories::meta();
    }

    /** Pre-call metadata for getUniverseCategoriesCategoryId. Equivalent to GetUniverseCategoriesCategoryId::meta(). */
    public static function getUniverseCategoriesCategoryIdMeta(): OperationMeta
    {
        return GetUniverseCategoriesCategoryId::meta();
    }

    /** Pre-call metadata for getUniverseConstellations. Equivalent to GetUniverseConstellations::meta(). */
    public static function getUniverseConstellationsMeta(): OperationMeta
    {
        return GetUniverseConstellations::meta();
    }

    /** Pre-call metadata for getUniverseConstellationsConstellationId. Equivalent to GetUniverseConstellationsConstellationId::meta(). */
    public static function getUniverseConstellationsConstellationIdMeta(): OperationMeta
    {
        return GetUniverseConstellationsConstellationId::meta();
    }

    /** Pre-call metadata for getUniverseFactions. Equivalent to GetUniverseFactions::meta(). */
    public static function getUniverseFactionsMeta(): OperationMeta
    {
        return GetUniverseFactions::meta();
    }

    /** Pre-call metadata for getUniverseGraphics. Equivalent to GetUniverseGraphics::meta(). */
    public static function getUniverseGraphicsMeta(): OperationMeta
    {
        return GetUniverseGraphics::meta();
    }

    /** Pre-call metadata for getUniverseGraphicsGraphicId. Equivalent to GetUniverseGraphicsGraphicId::meta(). */
    public static function getUniverseGraphicsGraphicIdMeta(): OperationMeta
    {
        return GetUniverseGraphicsGraphicId::meta();
    }

    /** Pre-call metadata for getUniverseGroups. Equivalent to GetUniverseGroups::meta(). */
    public static function getUniverseGroupsMeta(): OperationMeta
    {
        return GetUniverseGroups::meta();
    }

    /** Pre-call metadata for getUniverseGroupsGroupId. Equivalent to GetUniverseGroupsGroupId::meta(). */
    public static function getUniverseGroupsGroupIdMeta(): OperationMeta
    {
        return GetUniverseGroupsGroupId::meta();
    }

    /** Pre-call metadata for postUniverseIds. Equivalent to PostUniverseIds::meta(). */
    public static function postUniverseIdsMeta(): OperationMeta
    {
        return PostUniverseIds::meta();
    }

    /** Pre-call metadata for getUniverseMoonsMoonId. Equivalent to GetUniverseMoonsMoonId::meta(). */
    public static function getUniverseMoonsMoonIdMeta(): OperationMeta
    {
        return GetUniverseMoonsMoonId::meta();
    }

    /** Pre-call metadata for postUniverseNames. Equivalent to PostUniverseNames::meta(). */
    public static function postUniverseNamesMeta(): OperationMeta
    {
        return PostUniverseNames::meta();
    }

    /** Pre-call metadata for getUniversePlanetsPlanetId. Equivalent to GetUniversePlanetsPlanetId::meta(). */
    public static function getUniversePlanetsPlanetIdMeta(): OperationMeta
    {
        return GetUniversePlanetsPlanetId::meta();
    }

    /** Pre-call metadata for getUniverseRaces. Equivalent to GetUniverseRaces::meta(). */
    public static function getUniverseRacesMeta(): OperationMeta
    {
        return GetUniverseRaces::meta();
    }

    /** Pre-call metadata for getUniverseRegions. Equivalent to GetUniverseRegions::meta(). */
    public static function getUniverseRegionsMeta(): OperationMeta
    {
        return GetUniverseRegions::meta();
    }

    /** Pre-call metadata for getUniverseRegionsRegionId. Equivalent to GetUniverseRegionsRegionId::meta(). */
    public static function getUniverseRegionsRegionIdMeta(): OperationMeta
    {
        return GetUniverseRegionsRegionId::meta();
    }

    /** Pre-call metadata for getUniverseStargatesStargateId. Equivalent to GetUniverseStargatesStargateId::meta(). */
    public static function getUniverseStargatesStargateIdMeta(): OperationMeta
    {
        return GetUniverseStargatesStargateId::meta();
    }

    /** Pre-call metadata for getUniverseStarsStarId. Equivalent to GetUniverseStarsStarId::meta(). */
    public static function getUniverseStarsStarIdMeta(): OperationMeta
    {
        return GetUniverseStarsStarId::meta();
    }

    /** Pre-call metadata for getUniverseStationsStationId. Equivalent to GetUniverseStationsStationId::meta(). */
    public static function getUniverseStationsStationIdMeta(): OperationMeta
    {
        return GetUniverseStationsStationId::meta();
    }

    /** Pre-call metadata for getUniverseStructures. Equivalent to GetUniverseStructures::meta(). */
    public static function getUniverseStructuresMeta(): OperationMeta
    {
        return GetUniverseStructures::meta();
    }

    /** Pre-call metadata for getUniverseStructuresStructureId. Equivalent to GetUniverseStructuresStructureId::meta(). */
    public static function getUniverseStructuresStructureIdMeta(): OperationMeta
    {
        return GetUniverseStructuresStructureId::meta();
    }

    /** Pre-call metadata for getUniverseSystemJumps. Equivalent to GetUniverseSystemJumps::meta(). */
    public static function getUniverseSystemJumpsMeta(): OperationMeta
    {
        return GetUniverseSystemJumps::meta();
    }

    /** Pre-call metadata for getUniverseSystemKills. Equivalent to GetUniverseSystemKills::meta(). */
    public static function getUniverseSystemKillsMeta(): OperationMeta
    {
        return GetUniverseSystemKills::meta();
    }

    /** Pre-call metadata for getUniverseSystems. Equivalent to GetUniverseSystems::meta(). */
    public static function getUniverseSystemsMeta(): OperationMeta
    {
        return GetUniverseSystems::meta();
    }

    /** Pre-call metadata for getUniverseSystemsSystemId. Equivalent to GetUniverseSystemsSystemId::meta(). */
    public static function getUniverseSystemsSystemIdMeta(): OperationMeta
    {
        return GetUniverseSystemsSystemId::meta();
    }

    /** Pre-call metadata for getUniverseTypes. Equivalent to GetUniverseTypes::meta(). */
    public static function getUniverseTypesMeta(): OperationMeta
    {
        return GetUniverseTypes::meta();
    }

    /** Pre-call metadata for getUniverseTypesTypeId. Equivalent to GetUniverseTypesTypeId::meta(). */
    public static function getUniverseTypesTypeIdMeta(): OperationMeta
    {
        return GetUniverseTypesTypeId::meta();
    }

    /**
     * @return EsiResult<array<UniverseAncestriesGetItem>>
     */
    public function getUniverseAncestries(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/ancestries', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => UniverseAncestriesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
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
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseBloodlinesGetItem>>
     */
    public function getUniverseBloodlines(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/bloodlines', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => UniverseBloodlinesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseCategories(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/categories', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
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
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
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
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseFactionsGetItem>>
     */
    public function getUniverseFactions(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/factions', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => UniverseFactionsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseGraphics(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/graphics', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
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
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
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
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseNamesPostItem>>
     */
    public function postUniverseNames(mixed $requestBody): EsiResult
    {
        $response = $this->transport->invoke('post', '/universe/names', [], [], (array) $requestBody);
        return new EsiResult(
            data: array_map(
                fn (object $item) => UniverseNamesPostItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
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
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseRacesGetItem>>
     */
    public function getUniverseRaces(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/races', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => UniverseRacesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseRegions(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/regions', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
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
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
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
        return $dto;
    }

    /**
     * @return EsiResult<array<UniverseSystemJumpsGetItem>>
     */
    public function getUniverseSystemJumps(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/system_jumps', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => UniverseSystemJumpsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<UniverseSystemKillsGetItem>>
     */
    public function getUniverseSystemKills(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/system_kills', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => UniverseSystemKillsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getUniverseSystems(): EsiResult
    {
        $response = $this->transport->invoke('get', '/universe/systems', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
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
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
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
        return $dto;
    }
}
