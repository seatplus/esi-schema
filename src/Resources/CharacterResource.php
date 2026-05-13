<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersAffiliationPostItem;
use Seatplus\EsiSchema\Operations\Character\PostCharactersAffiliation;
use Seatplus\EsiSchema\Responses\CharactersDetail;
use Seatplus\EsiSchema\Operations\Character\GetCharactersCharacterId;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAgentsResearchGetItem;
use Seatplus\EsiSchema\Operations\Character\GetCharactersCharacterIdAgentsResearch;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdBlueprintsGetItem;
use Seatplus\EsiSchema\Operations\Character\GetCharactersCharacterIdBlueprints;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdCorporationhistoryGetItem;
use Seatplus\EsiSchema\Operations\Character\GetCharactersCharacterIdCorporationhistory;
use Seatplus\EsiSchema\Operations\Character\PostCharactersCharacterIdCspa;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFatigueGet;
use Seatplus\EsiSchema\Operations\Character\GetCharactersCharacterIdFatigue;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMedalsGetItem;
use Seatplus\EsiSchema\Operations\Character\GetCharactersCharacterIdMedals;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdNotificationsGetItem;
use Seatplus\EsiSchema\Operations\Character\GetCharactersCharacterIdNotifications;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdNotificationsContactsGetItem;
use Seatplus\EsiSchema\Operations\Character\GetCharactersCharacterIdNotificationsContacts;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdPortraitGet;
use Seatplus\EsiSchema\Operations\Character\GetCharactersCharacterIdPortrait;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdRolesGet;
use Seatplus\EsiSchema\Operations\Character\GetCharactersCharacterIdRoles;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdStandingsGetItem;
use Seatplus\EsiSchema\Operations\Character\GetCharactersCharacterIdStandings;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdTitlesGetItem;
use Seatplus\EsiSchema\Operations\Character\GetCharactersCharacterIdTitles;

/**
 * ESI tag: Character
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class CharacterResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'postCharactersAffiliation' => PostCharactersAffiliation::meta(),
            'getCharactersCharacterId' => GetCharactersCharacterId::meta(),
            'getCharactersCharacterIdAgentsResearch' => GetCharactersCharacterIdAgentsResearch::meta(),
            'getCharactersCharacterIdBlueprints' => GetCharactersCharacterIdBlueprints::meta(),
            'getCharactersCharacterIdCorporationhistory' => GetCharactersCharacterIdCorporationhistory::meta(),
            'postCharactersCharacterIdCspa' => PostCharactersCharacterIdCspa::meta(),
            'getCharactersCharacterIdFatigue' => GetCharactersCharacterIdFatigue::meta(),
            'getCharactersCharacterIdMedals' => GetCharactersCharacterIdMedals::meta(),
            'getCharactersCharacterIdNotifications' => GetCharactersCharacterIdNotifications::meta(),
            'getCharactersCharacterIdNotificationsContacts' => GetCharactersCharacterIdNotificationsContacts::meta(),
            'getCharactersCharacterIdPortrait' => GetCharactersCharacterIdPortrait::meta(),
            'getCharactersCharacterIdRoles' => GetCharactersCharacterIdRoles::meta(),
            'getCharactersCharacterIdStandings' => GetCharactersCharacterIdStandings::meta(),
            'getCharactersCharacterIdTitles' => GetCharactersCharacterIdTitles::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for postCharactersAffiliation. Equivalent to PostCharactersAffiliation::meta(). */
    public static function postCharactersAffiliationMeta(): OperationMeta
    {
        return PostCharactersAffiliation::meta();
    }

    /** Pre-call metadata for getCharactersCharacterId. Equivalent to GetCharactersCharacterId::meta(). */
    public static function getCharactersCharacterIdMeta(): OperationMeta
    {
        return GetCharactersCharacterId::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdAgentsResearch. Equivalent to GetCharactersCharacterIdAgentsResearch::meta(). */
    public static function getCharactersCharacterIdAgentsResearchMeta(): OperationMeta
    {
        return GetCharactersCharacterIdAgentsResearch::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdBlueprints. Equivalent to GetCharactersCharacterIdBlueprints::meta(). */
    public static function getCharactersCharacterIdBlueprintsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdBlueprints::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdCorporationhistory. Equivalent to GetCharactersCharacterIdCorporationhistory::meta(). */
    public static function getCharactersCharacterIdCorporationhistoryMeta(): OperationMeta
    {
        return GetCharactersCharacterIdCorporationhistory::meta();
    }

    /** Pre-call metadata for postCharactersCharacterIdCspa. Equivalent to PostCharactersCharacterIdCspa::meta(). */
    public static function postCharactersCharacterIdCspaMeta(): OperationMeta
    {
        return PostCharactersCharacterIdCspa::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdFatigue. Equivalent to GetCharactersCharacterIdFatigue::meta(). */
    public static function getCharactersCharacterIdFatigueMeta(): OperationMeta
    {
        return GetCharactersCharacterIdFatigue::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdMedals. Equivalent to GetCharactersCharacterIdMedals::meta(). */
    public static function getCharactersCharacterIdMedalsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdMedals::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdNotifications. Equivalent to GetCharactersCharacterIdNotifications::meta(). */
    public static function getCharactersCharacterIdNotificationsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdNotifications::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdNotificationsContacts. Equivalent to GetCharactersCharacterIdNotificationsContacts::meta(). */
    public static function getCharactersCharacterIdNotificationsContactsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdNotificationsContacts::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdPortrait. Equivalent to GetCharactersCharacterIdPortrait::meta(). */
    public static function getCharactersCharacterIdPortraitMeta(): OperationMeta
    {
        return GetCharactersCharacterIdPortrait::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdRoles. Equivalent to GetCharactersCharacterIdRoles::meta(). */
    public static function getCharactersCharacterIdRolesMeta(): OperationMeta
    {
        return GetCharactersCharacterIdRoles::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdStandings. Equivalent to GetCharactersCharacterIdStandings::meta(). */
    public static function getCharactersCharacterIdStandingsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdStandings::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdTitles. Equivalent to GetCharactersCharacterIdTitles::meta(). */
    public static function getCharactersCharacterIdTitlesMeta(): OperationMeta
    {
        return GetCharactersCharacterIdTitles::meta();
    }

    /**
     * @return EsiResult<array<CharactersAffiliationPostItem>>
     */
    public function postCharactersAffiliation(mixed $requestBody): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/affiliation', [], [], (array) $requestBody);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersAffiliationPostItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostCharactersAffiliation::meta(),
        );
    }

    /**
     * @return CharactersDetail
     */
    public function getCharactersCharacterId(int $characterId): CharactersDetail
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}', ['character_id' => $characterId], []);
        $dto = CharactersDetail::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCharactersCharacterId::meta();
        return $dto;
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdAgentsResearchGetItem>>
     * @scope esi-characters.read_agents_research.v1
     */
    public function getCharactersCharacterIdAgentsResearch(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/agents_research', ['character_id' => $characterId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdAgentsResearchGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdAgentsResearch::meta(),
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdBlueprintsGetItem>>
     * @scope esi-characters.read_blueprints.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdBlueprints(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/blueprints', ['character_id' => $characterId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdBlueprintsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdBlueprints::meta(),
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdCorporationhistoryGetItem>>
     */
    public function getCharactersCharacterIdCorporationhistory(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/corporationhistory', ['character_id' => $characterId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdCorporationhistoryGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdCorporationhistory::meta(),
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-characters.read_contacts.v1
     */
    public function postCharactersCharacterIdCspa(mixed $requestBody, int $characterId): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/cspa', ['character_id' => $characterId], [], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostCharactersCharacterIdCspa::meta(),
        );
    }

    /**
     * @return CharactersCharacterIdFatigueGet
     * @scope esi-characters.read_fatigue.v1
     */
    public function getCharactersCharacterIdFatigue(int $characterId): CharactersCharacterIdFatigueGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/fatigue', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdFatigueGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCharactersCharacterIdFatigue::meta();
        return $dto;
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdMedalsGetItem>>
     * @scope esi-characters.read_medals.v1
     */
    public function getCharactersCharacterIdMedals(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/medals', ['character_id' => $characterId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdMedalsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdMedals::meta(),
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdNotificationsGetItem>>
     * @scope esi-characters.read_notifications.v1
     */
    public function getCharactersCharacterIdNotifications(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/notifications', ['character_id' => $characterId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdNotificationsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdNotifications::meta(),
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdNotificationsContactsGetItem>>
     * @scope esi-characters.read_notifications.v1
     */
    public function getCharactersCharacterIdNotificationsContacts(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/notifications/contacts', ['character_id' => $characterId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdNotificationsContactsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdNotificationsContacts::meta(),
        );
    }

    /**
     * @return CharactersCharacterIdPortraitGet
     */
    public function getCharactersCharacterIdPortrait(int $characterId): CharactersCharacterIdPortraitGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/portrait', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdPortraitGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCharactersCharacterIdPortrait::meta();
        return $dto;
    }

    /**
     * @return CharactersCharacterIdRolesGet
     * @scope esi-characters.read_corporation_roles.v1
     */
    public function getCharactersCharacterIdRoles(int $characterId): CharactersCharacterIdRolesGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/roles', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdRolesGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCharactersCharacterIdRoles::meta();
        return $dto;
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdStandingsGetItem>>
     * @scope esi-characters.read_standings.v1
     */
    public function getCharactersCharacterIdStandings(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/standings', ['character_id' => $characterId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdStandingsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdStandings::meta(),
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdTitlesGetItem>>
     * @scope esi-characters.read_titles.v1
     */
    public function getCharactersCharacterIdTitles(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/titles', ['character_id' => $characterId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdTitlesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdTitles::meta(),
        );
    }
}
