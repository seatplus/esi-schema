<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFleetGet;
use Seatplus\EsiSchema\Operations\Fleets\GetCharactersCharacterIdFleet;
use Seatplus\EsiSchema\Responses\FleetsFleetIdGet;
use Seatplus\EsiSchema\Operations\Fleets\GetFleetsFleetId;
use Seatplus\EsiSchema\Operations\Fleets\PutFleetsFleetId;
use Seatplus\EsiSchema\Responses\FleetsFleetIdMembersGetItem;
use Seatplus\EsiSchema\Operations\Fleets\GetFleetsFleetIdMembers;
use Seatplus\EsiSchema\Operations\Fleets\PostFleetsFleetIdMembers;
use Seatplus\EsiSchema\Operations\Fleets\DeleteFleetsFleetIdMembersMemberId;
use Seatplus\EsiSchema\Operations\Fleets\PutFleetsFleetIdMembersMemberId;
use Seatplus\EsiSchema\Operations\Fleets\DeleteFleetsFleetIdSquadsSquadId;
use Seatplus\EsiSchema\Operations\Fleets\PutFleetsFleetIdSquadsSquadId;
use Seatplus\EsiSchema\Responses\FleetsFleetIdWingsGetItem;
use Seatplus\EsiSchema\Operations\Fleets\GetFleetsFleetIdWings;
use Seatplus\EsiSchema\Operations\Fleets\PostFleetsFleetIdWings;
use Seatplus\EsiSchema\Operations\Fleets\DeleteFleetsFleetIdWingsWingId;
use Seatplus\EsiSchema\Operations\Fleets\PutFleetsFleetIdWingsWingId;
use Seatplus\EsiSchema\Operations\Fleets\PostFleetsFleetIdWingsWingIdSquads;

/**
 * ESI tag: Fleets
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class FleetsResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdFleet' => GetCharactersCharacterIdFleet::meta(),
            'getFleetsFleetId' => GetFleetsFleetId::meta(),
            'putFleetsFleetId' => PutFleetsFleetId::meta(),
            'getFleetsFleetIdMembers' => GetFleetsFleetIdMembers::meta(),
            'postFleetsFleetIdMembers' => PostFleetsFleetIdMembers::meta(),
            'deleteFleetsFleetIdMembersMemberId' => DeleteFleetsFleetIdMembersMemberId::meta(),
            'putFleetsFleetIdMembersMemberId' => PutFleetsFleetIdMembersMemberId::meta(),
            'deleteFleetsFleetIdSquadsSquadId' => DeleteFleetsFleetIdSquadsSquadId::meta(),
            'putFleetsFleetIdSquadsSquadId' => PutFleetsFleetIdSquadsSquadId::meta(),
            'getFleetsFleetIdWings' => GetFleetsFleetIdWings::meta(),
            'postFleetsFleetIdWings' => PostFleetsFleetIdWings::meta(),
            'deleteFleetsFleetIdWingsWingId' => DeleteFleetsFleetIdWingsWingId::meta(),
            'putFleetsFleetIdWingsWingId' => PutFleetsFleetIdWingsWingId::meta(),
            'postFleetsFleetIdWingsWingIdSquads' => PostFleetsFleetIdWingsWingIdSquads::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdFleet. Equivalent to GetCharactersCharacterIdFleet::meta(). */
    public static function getCharactersCharacterIdFleetMeta(): OperationMeta
    {
        return GetCharactersCharacterIdFleet::meta();
    }

    /** Pre-call metadata for getFleetsFleetId. Equivalent to GetFleetsFleetId::meta(). */
    public static function getFleetsFleetIdMeta(): OperationMeta
    {
        return GetFleetsFleetId::meta();
    }

    /** Pre-call metadata for putFleetsFleetId. Equivalent to PutFleetsFleetId::meta(). */
    public static function putFleetsFleetIdMeta(): OperationMeta
    {
        return PutFleetsFleetId::meta();
    }

    /** Pre-call metadata for getFleetsFleetIdMembers. Equivalent to GetFleetsFleetIdMembers::meta(). */
    public static function getFleetsFleetIdMembersMeta(): OperationMeta
    {
        return GetFleetsFleetIdMembers::meta();
    }

    /** Pre-call metadata for postFleetsFleetIdMembers. Equivalent to PostFleetsFleetIdMembers::meta(). */
    public static function postFleetsFleetIdMembersMeta(): OperationMeta
    {
        return PostFleetsFleetIdMembers::meta();
    }

    /** Pre-call metadata for deleteFleetsFleetIdMembersMemberId. Equivalent to DeleteFleetsFleetIdMembersMemberId::meta(). */
    public static function deleteFleetsFleetIdMembersMemberIdMeta(): OperationMeta
    {
        return DeleteFleetsFleetIdMembersMemberId::meta();
    }

    /** Pre-call metadata for putFleetsFleetIdMembersMemberId. Equivalent to PutFleetsFleetIdMembersMemberId::meta(). */
    public static function putFleetsFleetIdMembersMemberIdMeta(): OperationMeta
    {
        return PutFleetsFleetIdMembersMemberId::meta();
    }

    /** Pre-call metadata for deleteFleetsFleetIdSquadsSquadId. Equivalent to DeleteFleetsFleetIdSquadsSquadId::meta(). */
    public static function deleteFleetsFleetIdSquadsSquadIdMeta(): OperationMeta
    {
        return DeleteFleetsFleetIdSquadsSquadId::meta();
    }

    /** Pre-call metadata for putFleetsFleetIdSquadsSquadId. Equivalent to PutFleetsFleetIdSquadsSquadId::meta(). */
    public static function putFleetsFleetIdSquadsSquadIdMeta(): OperationMeta
    {
        return PutFleetsFleetIdSquadsSquadId::meta();
    }

    /** Pre-call metadata for getFleetsFleetIdWings. Equivalent to GetFleetsFleetIdWings::meta(). */
    public static function getFleetsFleetIdWingsMeta(): OperationMeta
    {
        return GetFleetsFleetIdWings::meta();
    }

    /** Pre-call metadata for postFleetsFleetIdWings. Equivalent to PostFleetsFleetIdWings::meta(). */
    public static function postFleetsFleetIdWingsMeta(): OperationMeta
    {
        return PostFleetsFleetIdWings::meta();
    }

    /** Pre-call metadata for deleteFleetsFleetIdWingsWingId. Equivalent to DeleteFleetsFleetIdWingsWingId::meta(). */
    public static function deleteFleetsFleetIdWingsWingIdMeta(): OperationMeta
    {
        return DeleteFleetsFleetIdWingsWingId::meta();
    }

    /** Pre-call metadata for putFleetsFleetIdWingsWingId. Equivalent to PutFleetsFleetIdWingsWingId::meta(). */
    public static function putFleetsFleetIdWingsWingIdMeta(): OperationMeta
    {
        return PutFleetsFleetIdWingsWingId::meta();
    }

    /** Pre-call metadata for postFleetsFleetIdWingsWingIdSquads. Equivalent to PostFleetsFleetIdWingsWingIdSquads::meta(). */
    public static function postFleetsFleetIdWingsWingIdSquadsMeta(): OperationMeta
    {
        return PostFleetsFleetIdWingsWingIdSquads::meta();
    }

    /**
     * @return CharactersCharacterIdFleetGet
     * @scope esi-fleets.read_fleet.v1
     */
    public function getCharactersCharacterIdFleet(int $characterId): CharactersCharacterIdFleetGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/fleet', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdFleetGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return FleetsFleetIdGet
     * @scope esi-fleets.read_fleet.v1
     */
    public function getFleetsFleetId(int $fleetId): FleetsFleetIdGet
    {
        $response = $this->transport->invoke('get', '/fleets/{fleet_id}', ['fleet_id' => $fleetId], []);
        $dto = FleetsFleetIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fleets.write_fleet.v1
     */
    public function putFleetsFleetId(mixed $requestBody, int $fleetId): EsiResult
    {
        $response = $this->transport->invoke('put', '/fleets/{fleet_id}', ['fleet_id' => $fleetId], [], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<FleetsFleetIdMembersGetItem>>
     * @scope esi-fleets.read_fleet.v1
     */
    public function getFleetsFleetIdMembers(int $fleetId): EsiResult
    {
        $response = $this->transport->invoke('get', '/fleets/{fleet_id}/members', ['fleet_id' => $fleetId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => FleetsFleetIdMembersGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fleets.write_fleet.v1
     */
    public function postFleetsFleetIdMembers(mixed $requestBody, int $fleetId): EsiResult
    {
        $response = $this->transport->invoke('post', '/fleets/{fleet_id}/members', ['fleet_id' => $fleetId], [], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fleets.write_fleet.v1
     */
    public function deleteFleetsFleetIdMembersMemberId(int $fleetId, int $memberId): EsiResult
    {
        $response = $this->transport->invoke('delete', '/fleets/{fleet_id}/members/{member_id}', ['fleet_id' => $fleetId, 'member_id' => $memberId], [], []);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fleets.write_fleet.v1
     */
    public function putFleetsFleetIdMembersMemberId(mixed $requestBody, int $fleetId, int $memberId): EsiResult
    {
        $response = $this->transport->invoke('put', '/fleets/{fleet_id}/members/{member_id}', ['fleet_id' => $fleetId, 'member_id' => $memberId], [], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fleets.write_fleet.v1
     */
    public function deleteFleetsFleetIdSquadsSquadId(int $fleetId, int $squadId): EsiResult
    {
        $response = $this->transport->invoke('delete', '/fleets/{fleet_id}/squads/{squad_id}', ['fleet_id' => $fleetId, 'squad_id' => $squadId], [], []);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fleets.write_fleet.v1
     */
    public function putFleetsFleetIdSquadsSquadId(mixed $requestBody, int $fleetId, int $squadId): EsiResult
    {
        $response = $this->transport->invoke('put', '/fleets/{fleet_id}/squads/{squad_id}', ['fleet_id' => $fleetId, 'squad_id' => $squadId], [], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<FleetsFleetIdWingsGetItem>>
     * @scope esi-fleets.read_fleet.v1
     */
    public function getFleetsFleetIdWings(int $fleetId): EsiResult
    {
        $response = $this->transport->invoke('get', '/fleets/{fleet_id}/wings', ['fleet_id' => $fleetId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => FleetsFleetIdWingsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fleets.write_fleet.v1
     */
    public function postFleetsFleetIdWings(int $fleetId): EsiResult
    {
        $response = $this->transport->invoke('post', '/fleets/{fleet_id}/wings', ['fleet_id' => $fleetId], [], []);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fleets.write_fleet.v1
     */
    public function deleteFleetsFleetIdWingsWingId(int $fleetId, int $wingId): EsiResult
    {
        $response = $this->transport->invoke('delete', '/fleets/{fleet_id}/wings/{wing_id}', ['fleet_id' => $fleetId, 'wing_id' => $wingId], [], []);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fleets.write_fleet.v1
     */
    public function putFleetsFleetIdWingsWingId(mixed $requestBody, int $fleetId, int $wingId): EsiResult
    {
        $response = $this->transport->invoke('put', '/fleets/{fleet_id}/wings/{wing_id}', ['fleet_id' => $fleetId, 'wing_id' => $wingId], [], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fleets.write_fleet.v1
     */
    public function postFleetsFleetIdWingsWingIdSquads(int $fleetId, int $wingId): EsiResult
    {
        $response = $this->transport->invoke('post', '/fleets/{fleet_id}/wings/{wing_id}/squads', ['fleet_id' => $fleetId, 'wing_id' => $wingId], [], []);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }
}
