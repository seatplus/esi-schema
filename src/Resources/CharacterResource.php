<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Character\PostCharactersAffiliation;
use Seatplus\EsiSchema\Resources\Character\GetCharactersDetail;
use Seatplus\EsiSchema\Responses\CharactersDetail;
use Seatplus\EsiSchema\Resources\Character\GetCharactersCharacterIdAgentsResearch;
use Seatplus\EsiSchema\Resources\Character\GetCharactersCharacterIdBlueprints;
use Seatplus\EsiSchema\Resources\Character\GetCharactersCharacterIdCorporationhistory;
use Seatplus\EsiSchema\Resources\Character\PostCharactersCharacterIdCspa;
use Seatplus\EsiSchema\Resources\Character\GetCharactersCharacterIdFatigue;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFatigueGet;
use Seatplus\EsiSchema\Resources\Character\GetCharactersCharacterIdMedals;
use Seatplus\EsiSchema\Resources\Character\GetCharactersCharacterIdNotifications;
use Seatplus\EsiSchema\Resources\Character\GetCharactersCharacterIdNotificationsContacts;
use Seatplus\EsiSchema\Resources\Character\GetCharactersCharacterIdPortrait;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdPortraitGet;
use Seatplus\EsiSchema\Resources\Character\GetCharactersCharacterIdRoles;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdRolesGet;
use Seatplus\EsiSchema\Resources\Character\GetCharactersCharacterIdStandings;
use Seatplus\EsiSchema\Resources\Character\GetCharactersCharacterIdTitles;

/**
 * ESI Character resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharacterResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     */
    public function postCharactersAffiliation(mixed $requestBody): EsiResult
    {
        return PostCharactersAffiliation::execute($this->transport, $requestBody);
    }

    /**
     * @return CharactersDetail
     */
    public function getCharactersDetail(int $characterId): CharactersDetail
    {
        return GetCharactersDetail::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-characters.read_agents_research.v1
     */
    public function getCharactersCharacterIdAgentsResearch(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdAgentsResearch::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-characters.read_blueprints.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdBlueprints(int $characterId, int $page = 1): EsiResult
    {
        return GetCharactersCharacterIdBlueprints::execute($this->transport, $characterId, $page);
    }

    /**
     * @return EsiResult
     */
    public function getCharactersCharacterIdCorporationhistory(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdCorporationhistory::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-characters.read_contacts.v1
     */
    public function postCharactersCharacterIdCspa(mixed $requestBody, int $characterId): EsiResult
    {
        return PostCharactersCharacterIdCspa::execute($this->transport, $requestBody, $characterId);
    }

    /**
     * @return CharactersCharacterIdFatigueGet
     * @scope esi-characters.read_fatigue.v1
     */
    public function getCharactersCharacterIdFatigue(int $characterId): CharactersCharacterIdFatigueGet
    {
        return GetCharactersCharacterIdFatigue::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-characters.read_medals.v1
     */
    public function getCharactersCharacterIdMedals(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdMedals::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-characters.read_notifications.v1
     */
    public function getCharactersCharacterIdNotifications(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdNotifications::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-characters.read_notifications.v1
     */
    public function getCharactersCharacterIdNotificationsContacts(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdNotificationsContacts::execute($this->transport, $characterId);
    }

    /**
     * @return CharactersCharacterIdPortraitGet
     */
    public function getCharactersCharacterIdPortrait(int $characterId): CharactersCharacterIdPortraitGet
    {
        return GetCharactersCharacterIdPortrait::execute($this->transport, $characterId);
    }

    /**
     * @return CharactersCharacterIdRolesGet
     * @scope esi-characters.read_corporation_roles.v1
     */
    public function getCharactersCharacterIdRoles(int $characterId): CharactersCharacterIdRolesGet
    {
        return GetCharactersCharacterIdRoles::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-characters.read_standings.v1
     */
    public function getCharactersCharacterIdStandings(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdStandings::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-characters.read_titles.v1
     */
    public function getCharactersCharacterIdTitles(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdTitles::execute($this->transport, $characterId);
    }
}
