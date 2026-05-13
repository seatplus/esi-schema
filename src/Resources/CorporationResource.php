<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsNpccorps;
use Seatplus\EsiSchema\Responses\CorporationsDetail;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationId;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdAlliancehistoryGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdAlliancehistory;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdBlueprintsGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdBlueprints;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdContainersLogsGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdContainersLogs;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdDivisionsGet;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdDivisions;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdFacilitiesGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdFacilities;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdIconsGet;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdIcons;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdMedalsGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdMedals;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdMedalsIssuedGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdMedalsIssued;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdMembers;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdMembersLimit;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdMembersTitlesGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdMembersTitles;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdMembertrackingGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdMembertracking;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdRolesGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdRoles;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdRolesHistoryGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdRolesHistory;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdShareholdersGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdShareholders;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdStandingsGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdStandings;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdStarbasesGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdStarbases;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdStarbasesStarbaseIdGet;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdStarbasesStarbaseId;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdStructuresGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdStructures;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdTitlesGetItem;
use Seatplus\EsiSchema\Operations\Corporation\GetCorporationsCorporationIdTitles;

/**
 * ESI tag: Corporation
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class CorporationResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCorporationsNpccorps' => GetCorporationsNpccorps::meta(),
            'getCorporationsCorporationId' => GetCorporationsCorporationId::meta(),
            'getCorporationsCorporationIdAlliancehistory' => GetCorporationsCorporationIdAlliancehistory::meta(),
            'getCorporationsCorporationIdBlueprints' => GetCorporationsCorporationIdBlueprints::meta(),
            'getCorporationsCorporationIdContainersLogs' => GetCorporationsCorporationIdContainersLogs::meta(),
            'getCorporationsCorporationIdDivisions' => GetCorporationsCorporationIdDivisions::meta(),
            'getCorporationsCorporationIdFacilities' => GetCorporationsCorporationIdFacilities::meta(),
            'getCorporationsCorporationIdIcons' => GetCorporationsCorporationIdIcons::meta(),
            'getCorporationsCorporationIdMedals' => GetCorporationsCorporationIdMedals::meta(),
            'getCorporationsCorporationIdMedalsIssued' => GetCorporationsCorporationIdMedalsIssued::meta(),
            'getCorporationsCorporationIdMembers' => GetCorporationsCorporationIdMembers::meta(),
            'getCorporationsCorporationIdMembersLimit' => GetCorporationsCorporationIdMembersLimit::meta(),
            'getCorporationsCorporationIdMembersTitles' => GetCorporationsCorporationIdMembersTitles::meta(),
            'getCorporationsCorporationIdMembertracking' => GetCorporationsCorporationIdMembertracking::meta(),
            'getCorporationsCorporationIdRoles' => GetCorporationsCorporationIdRoles::meta(),
            'getCorporationsCorporationIdRolesHistory' => GetCorporationsCorporationIdRolesHistory::meta(),
            'getCorporationsCorporationIdShareholders' => GetCorporationsCorporationIdShareholders::meta(),
            'getCorporationsCorporationIdStandings' => GetCorporationsCorporationIdStandings::meta(),
            'getCorporationsCorporationIdStarbases' => GetCorporationsCorporationIdStarbases::meta(),
            'getCorporationsCorporationIdStarbasesStarbaseId' => GetCorporationsCorporationIdStarbasesStarbaseId::meta(),
            'getCorporationsCorporationIdStructures' => GetCorporationsCorporationIdStructures::meta(),
            'getCorporationsCorporationIdTitles' => GetCorporationsCorporationIdTitles::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCorporationsNpccorps. Equivalent to GetCorporationsNpccorps::meta(). */
    public static function getCorporationsNpccorpsMeta(): OperationMeta
    {
        return GetCorporationsNpccorps::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationId. Equivalent to GetCorporationsCorporationId::meta(). */
    public static function getCorporationsCorporationIdMeta(): OperationMeta
    {
        return GetCorporationsCorporationId::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdAlliancehistory. Equivalent to GetCorporationsCorporationIdAlliancehistory::meta(). */
    public static function getCorporationsCorporationIdAlliancehistoryMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdAlliancehistory::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdBlueprints. Equivalent to GetCorporationsCorporationIdBlueprints::meta(). */
    public static function getCorporationsCorporationIdBlueprintsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdBlueprints::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdContainersLogs. Equivalent to GetCorporationsCorporationIdContainersLogs::meta(). */
    public static function getCorporationsCorporationIdContainersLogsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdContainersLogs::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdDivisions. Equivalent to GetCorporationsCorporationIdDivisions::meta(). */
    public static function getCorporationsCorporationIdDivisionsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdDivisions::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdFacilities. Equivalent to GetCorporationsCorporationIdFacilities::meta(). */
    public static function getCorporationsCorporationIdFacilitiesMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdFacilities::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdIcons. Equivalent to GetCorporationsCorporationIdIcons::meta(). */
    public static function getCorporationsCorporationIdIconsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdIcons::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdMedals. Equivalent to GetCorporationsCorporationIdMedals::meta(). */
    public static function getCorporationsCorporationIdMedalsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdMedals::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdMedalsIssued. Equivalent to GetCorporationsCorporationIdMedalsIssued::meta(). */
    public static function getCorporationsCorporationIdMedalsIssuedMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdMedalsIssued::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdMembers. Equivalent to GetCorporationsCorporationIdMembers::meta(). */
    public static function getCorporationsCorporationIdMembersMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdMembers::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdMembersLimit. Equivalent to GetCorporationsCorporationIdMembersLimit::meta(). */
    public static function getCorporationsCorporationIdMembersLimitMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdMembersLimit::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdMembersTitles. Equivalent to GetCorporationsCorporationIdMembersTitles::meta(). */
    public static function getCorporationsCorporationIdMembersTitlesMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdMembersTitles::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdMembertracking. Equivalent to GetCorporationsCorporationIdMembertracking::meta(). */
    public static function getCorporationsCorporationIdMembertrackingMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdMembertracking::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdRoles. Equivalent to GetCorporationsCorporationIdRoles::meta(). */
    public static function getCorporationsCorporationIdRolesMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdRoles::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdRolesHistory. Equivalent to GetCorporationsCorporationIdRolesHistory::meta(). */
    public static function getCorporationsCorporationIdRolesHistoryMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdRolesHistory::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdShareholders. Equivalent to GetCorporationsCorporationIdShareholders::meta(). */
    public static function getCorporationsCorporationIdShareholdersMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdShareholders::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdStandings. Equivalent to GetCorporationsCorporationIdStandings::meta(). */
    public static function getCorporationsCorporationIdStandingsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdStandings::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdStarbases. Equivalent to GetCorporationsCorporationIdStarbases::meta(). */
    public static function getCorporationsCorporationIdStarbasesMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdStarbases::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdStarbasesStarbaseId. Equivalent to GetCorporationsCorporationIdStarbasesStarbaseId::meta(). */
    public static function getCorporationsCorporationIdStarbasesStarbaseIdMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdStarbasesStarbaseId::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdStructures. Equivalent to GetCorporationsCorporationIdStructures::meta(). */
    public static function getCorporationsCorporationIdStructuresMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdStructures::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdTitles. Equivalent to GetCorporationsCorporationIdTitles::meta(). */
    public static function getCorporationsCorporationIdTitlesMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdTitles::meta();
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getCorporationsNpccorps(): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/npccorps', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsNpccorps::meta(),
        );
    }

    /**
     * @return CorporationsDetail
     */
    public function getCorporationsCorporationId(int $corporationId): CorporationsDetail
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}', ['corporation_id' => $corporationId], []);
        $dto = CorporationsDetail::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCorporationsCorporationId::meta();
        return $dto;
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdAlliancehistoryGetItem>>
     */
    public function getCorporationsCorporationIdAlliancehistory(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/alliancehistory', ['corporation_id' => $corporationId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdAlliancehistoryGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdAlliancehistory::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdBlueprintsGetItem>>
     * @scope esi-corporations.read_blueprints.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdBlueprints(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/blueprints', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdBlueprintsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdBlueprints::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdContainersLogsGetItem>>
     * @scope esi-corporations.read_container_logs.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdContainersLogs(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/containers/logs', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdContainersLogsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdContainersLogs::meta(),
        );
    }

    /**
     * @return CorporationsCorporationIdDivisionsGet
     * @scope esi-corporations.read_divisions.v1
     */
    public function getCorporationsCorporationIdDivisions(int $corporationId): CorporationsCorporationIdDivisionsGet
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/divisions', ['corporation_id' => $corporationId], []);
        $dto = CorporationsCorporationIdDivisionsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCorporationsCorporationIdDivisions::meta();
        return $dto;
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdFacilitiesGetItem>>
     * @scope esi-corporations.read_facilities.v1
     */
    public function getCorporationsCorporationIdFacilities(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/facilities', ['corporation_id' => $corporationId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdFacilitiesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdFacilities::meta(),
        );
    }

    /**
     * @return CorporationsCorporationIdIconsGet
     */
    public function getCorporationsCorporationIdIcons(int $corporationId): CorporationsCorporationIdIconsGet
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/icons', ['corporation_id' => $corporationId], []);
        $dto = CorporationsCorporationIdIconsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCorporationsCorporationIdIcons::meta();
        return $dto;
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdMedalsGetItem>>
     * @scope esi-corporations.read_medals.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdMedals(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/medals', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdMedalsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdMedals::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdMedalsIssuedGetItem>>
     * @scope esi-corporations.read_medals.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdMedalsIssued(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/medals/issued', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdMedalsIssuedGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdMedalsIssued::meta(),
        );
    }

    /**
     * @return EsiResult<array<int>>
     * @scope esi-corporations.read_corporation_membership.v1
     */
    public function getCorporationsCorporationIdMembers(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/members', ['corporation_id' => $corporationId], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdMembers::meta(),
        );
    }

    /**
     * @return EsiResult<int>
     * @scope esi-corporations.track_members.v1
     */
    public function getCorporationsCorporationIdMembersLimit(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/members/limit', ['corporation_id' => $corporationId], []);
        /** @var int $scalar */
        $scalar = (int) $response->data;
        return new EsiResult(
            data: $scalar,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdMembersLimit::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdMembersTitlesGetItem>>
     * @scope esi-corporations.read_titles.v1
     */
    public function getCorporationsCorporationIdMembersTitles(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/members/titles', ['corporation_id' => $corporationId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdMembersTitlesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdMembersTitles::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdMembertrackingGetItem>>
     * @scope esi-corporations.track_members.v1
     */
    public function getCorporationsCorporationIdMembertracking(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/membertracking', ['corporation_id' => $corporationId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdMembertrackingGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdMembertracking::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdRolesGetItem>>
     * @scope esi-corporations.read_corporation_membership.v1
     */
    public function getCorporationsCorporationIdRoles(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/roles', ['corporation_id' => $corporationId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdRolesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdRoles::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdRolesHistoryGetItem>>
     * @scope esi-corporations.read_corporation_membership.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdRolesHistory(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/roles/history', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdRolesHistoryGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdRolesHistory::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdShareholdersGetItem>>
     * @scope esi-wallet.read_corporation_wallets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdShareholders(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/shareholders', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdShareholdersGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdShareholders::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdStandingsGetItem>>
     * @scope esi-corporations.read_standings.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdStandings(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/standings', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdStandingsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdStandings::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdStarbasesGetItem>>
     * @scope esi-corporations.read_starbases.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdStarbases(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/starbases', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdStarbasesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdStarbases::meta(),
        );
    }

    /**
     * @return CorporationsCorporationIdStarbasesStarbaseIdGet
     * @scope esi-corporations.read_starbases.v1
     */
    public function getCorporationsCorporationIdStarbasesStarbaseId(int $corporationId, int $starbaseId, int $systemId): CorporationsCorporationIdStarbasesStarbaseIdGet
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/starbases/{starbase_id}', ['corporation_id' => $corporationId, 'starbase_id' => $starbaseId], ['system_id' => $systemId]);
        $dto = CorporationsCorporationIdStarbasesStarbaseIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCorporationsCorporationIdStarbasesStarbaseId::meta();
        return $dto;
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdStructuresGetItem>>
     * @scope esi-corporations.read_structures.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdStructures(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/structures', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdStructuresGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdStructures::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdTitlesGetItem>>
     * @scope esi-corporations.read_titles.v1
     */
    public function getCorporationsCorporationIdTitles(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/titles', ['corporation_id' => $corporationId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdTitlesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdTitles::meta(),
        );
    }
}
