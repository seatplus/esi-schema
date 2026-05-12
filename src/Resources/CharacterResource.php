<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersAffiliationPostItem;
use Seatplus\EsiSchema\Responses\CharactersDetail;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAgentsResearchGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdBlueprintsGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdCorporationhistoryGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFatigueGet;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMedalsGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdNotificationsGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdNotificationsContactsGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdPortraitGet;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdRolesGet;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdStandingsGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdTitlesGetItem;

/**
 * ESI tag: Character
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class CharacterResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'postCharactersAffiliation' => ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterId' => ['cacheAge' => 86400, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdAgentsResearch' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdBlueprints' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdCorporationhistory' => ['cacheAge' => 86400, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'postCharactersCharacterIdCspa' => ['cacheAge' => null, 'rateLimit' => ['group' => 'char-detail', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdFatigue' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'char-location', 'max-tokens' => 1200, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdMedals' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-detail', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdNotifications' => ['cacheAge' => 600, 'rateLimit' => ['group' => 'char-notification', 'max-tokens' => 15, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdNotificationsContacts' => ['cacheAge' => 600, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdPortrait' => ['cacheAge' => null, 'rateLimit' => ['group' => 'char-detail', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdRoles' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-detail', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdStandings' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdTitles' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-detail', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
    ];

    /**
     * @return EsiResult<array<CharactersAffiliationPostItem>>
     */
    public function postCharactersAffiliation(mixed $requestBody): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/affiliation', [], [], (array) $requestBody);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersAffiliationPostItem::from($item),
            (array) $response->data,
        ));
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
        return $dto;
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdAgentsResearchGetItem>>
     * @scope esi-characters.read_agents_research.v1
     */
    public function getCharactersCharacterIdAgentsResearch(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/agents_research', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdAgentsResearchGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdBlueprintsGetItem>>
     * @scope esi-characters.read_blueprints.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdBlueprints(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/blueprints', ['character_id' => $characterId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdBlueprintsGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdCorporationhistoryGetItem>>
     */
    public function getCharactersCharacterIdCorporationhistory(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/corporationhistory', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdCorporationhistoryGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<null>
     * @scope esi-characters.read_contacts.v1
     */
    public function postCharactersCharacterIdCspa(mixed $requestBody, int $characterId): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/cspa', ['character_id' => $characterId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, null);
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
        return $dto;
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdMedalsGetItem>>
     * @scope esi-characters.read_medals.v1
     */
    public function getCharactersCharacterIdMedals(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/medals', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdMedalsGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdNotificationsGetItem>>
     * @scope esi-characters.read_notifications.v1
     */
    public function getCharactersCharacterIdNotifications(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/notifications', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdNotificationsGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdNotificationsContactsGetItem>>
     * @scope esi-characters.read_notifications.v1
     */
    public function getCharactersCharacterIdNotificationsContacts(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/notifications/contacts', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdNotificationsContactsGetItem::from($item),
            (array) $response->data,
        ));
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
        return $dto;
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdStandingsGetItem>>
     * @scope esi-characters.read_standings.v1
     */
    public function getCharactersCharacterIdStandings(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/standings', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdStandingsGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdTitlesGetItem>>
     * @scope esi-characters.read_titles.v1
     */
    public function getCharactersCharacterIdTitles(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/titles', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdTitlesGetItem::from($item),
            (array) $response->data,
        ));
    }
}
