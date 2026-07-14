<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Fleets\GetCharactersCharacterIdFleet;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFleetGet;
use Seatplus\EsiSchema\Resources\Fleets\GetFleetsFleetId;
use Seatplus\EsiSchema\Responses\FleetsFleetIdGet;
use Seatplus\EsiSchema\Resources\Fleets\PutFleetsFleetId;
use Seatplus\EsiSchema\Resources\Fleets\GetFleetsFleetIdMembers;
use Seatplus\EsiSchema\Resources\Fleets\PostFleetsFleetIdMembers;
use Seatplus\EsiSchema\Resources\Fleets\DeleteFleetsFleetIdMembersMemberId;
use Seatplus\EsiSchema\Resources\Fleets\PutFleetsFleetIdMembersMemberId;
use Seatplus\EsiSchema\Resources\Fleets\DeleteFleetsFleetIdSquadsSquadId;
use Seatplus\EsiSchema\Resources\Fleets\PutFleetsFleetIdSquadsSquadId;
use Seatplus\EsiSchema\Resources\Fleets\GetFleetsFleetIdWings;
use Seatplus\EsiSchema\Resources\Fleets\PostFleetsFleetIdWings;
use Seatplus\EsiSchema\Resources\Fleets\DeleteFleetsFleetIdWingsWingId;
use Seatplus\EsiSchema\Resources\Fleets\PutFleetsFleetIdWingsWingId;
use Seatplus\EsiSchema\Resources\Fleets\PostFleetsFleetIdWingsWingIdSquads;

/**
 * ESI Fleets resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FleetsResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return CharactersCharacterIdFleetGet
     * @scope esi-fleets.read_fleet.v1
     */
    public function getCharactersCharacterIdFleet(int $characterId): CharactersCharacterIdFleetGet
    {
        return GetCharactersCharacterIdFleet::execute($this->transport, $characterId);
    }

    /**
     * @return FleetsFleetIdGet
     * @scope esi-fleets.read_fleet.v1
     */
    public function getFleetsFleetId(int $fleetId): FleetsFleetIdGet
    {
        return GetFleetsFleetId::execute($this->transport, $fleetId);
    }

    /**
     * @return EsiResult
     * @scope esi-fleets.write_fleet.v1
     */
    public function putFleetsFleetId(mixed $requestBody, int $fleetId): EsiResult
    {
        return PutFleetsFleetId::execute($this->transport, $requestBody, $fleetId);
    }

    /**
     * @return EsiResult
     * @scope esi-fleets.read_fleet.v1
     */
    public function getFleetsFleetIdMembers(int $fleetId): EsiResult
    {
        return GetFleetsFleetIdMembers::execute($this->transport, $fleetId);
    }

    /**
     * @return EsiResult
     * @scope esi-fleets.write_fleet.v1
     */
    public function postFleetsFleetIdMembers(mixed $requestBody, int $fleetId): EsiResult
    {
        return PostFleetsFleetIdMembers::execute($this->transport, $requestBody, $fleetId);
    }

    /**
     * @return EsiResult
     * @scope esi-fleets.write_fleet.v1
     */
    public function deleteFleetsFleetIdMembersMemberId(int $fleetId, int $memberId): EsiResult
    {
        return DeleteFleetsFleetIdMembersMemberId::execute($this->transport, $fleetId, $memberId);
    }

    /**
     * @return EsiResult
     * @scope esi-fleets.write_fleet.v1
     */
    public function putFleetsFleetIdMembersMemberId(mixed $requestBody, int $fleetId, int $memberId): EsiResult
    {
        return PutFleetsFleetIdMembersMemberId::execute($this->transport, $requestBody, $fleetId, $memberId);
    }

    /**
     * @return EsiResult
     * @scope esi-fleets.write_fleet.v1
     */
    public function deleteFleetsFleetIdSquadsSquadId(int $fleetId, int $squadId): EsiResult
    {
        return DeleteFleetsFleetIdSquadsSquadId::execute($this->transport, $fleetId, $squadId);
    }

    /**
     * @return EsiResult
     * @scope esi-fleets.write_fleet.v1
     */
    public function putFleetsFleetIdSquadsSquadId(mixed $requestBody, int $fleetId, int $squadId): EsiResult
    {
        return PutFleetsFleetIdSquadsSquadId::execute($this->transport, $requestBody, $fleetId, $squadId);
    }

    /**
     * @return EsiResult
     * @scope esi-fleets.read_fleet.v1
     */
    public function getFleetsFleetIdWings(int $fleetId): EsiResult
    {
        return GetFleetsFleetIdWings::execute($this->transport, $fleetId);
    }

    /**
     * @return EsiResult
     * @scope esi-fleets.write_fleet.v1
     */
    public function postFleetsFleetIdWings(int $fleetId): EsiResult
    {
        return PostFleetsFleetIdWings::execute($this->transport, $fleetId);
    }

    /**
     * @return EsiResult
     * @scope esi-fleets.write_fleet.v1
     */
    public function deleteFleetsFleetIdWingsWingId(int $fleetId, int $wingId): EsiResult
    {
        return DeleteFleetsFleetIdWingsWingId::execute($this->transport, $fleetId, $wingId);
    }

    /**
     * @return EsiResult
     * @scope esi-fleets.write_fleet.v1
     */
    public function putFleetsFleetIdWingsWingId(mixed $requestBody, int $fleetId, int $wingId): EsiResult
    {
        return PutFleetsFleetIdWingsWingId::execute($this->transport, $requestBody, $fleetId, $wingId);
    }

    /**
     * @return EsiResult
     * @scope esi-fleets.write_fleet.v1
     */
    public function postFleetsFleetIdWingsWingIdSquads(int $fleetId, int $wingId): EsiResult
    {
        return PostFleetsFleetIdWingsWingIdSquads::execute($this->transport, $fleetId, $wingId);
    }
}
