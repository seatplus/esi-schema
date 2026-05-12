<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\AlliancesAllianceIdContactsGetItem;
use Seatplus\EsiSchema\Responses\AlliancesAllianceIdContactsLabelsGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdContactsGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdContactsLabelsGetItem;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdContactsGetItem;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdContactsLabelsGetItem;

/**
 * ESI tag: Contacts
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class ContactsResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getAlliancesAllianceIdContacts' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'alliance-social', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-alliances.read_contacts.v1'],
        'getAlliancesAllianceIdContactsLabels' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'alliance-social', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-alliances.read_contacts.v1'],
        'deleteCharactersCharacterIdContacts' => ['cacheAge' => null, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-characters.write_contacts.v1'],
        'getCharactersCharacterIdContacts' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-characters.read_contacts.v1'],
        'postCharactersCharacterIdContacts' => ['cacheAge' => null, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-characters.write_contacts.v1'],
        'putCharactersCharacterIdContacts' => ['cacheAge' => null, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-characters.write_contacts.v1'],
        'getCharactersCharacterIdContactsLabels' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-characters.read_contacts.v1'],
        'getCorporationsCorporationIdContacts' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'corp-social', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-corporations.read_contacts.v1'],
        'getCorporationsCorporationIdContactsLabels' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'corp-social', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-corporations.read_contacts.v1'],
    ];

    /**
     * @return EsiResult<array<AlliancesAllianceIdContactsGetItem>>
     * @scope esi-alliances.read_contacts.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getAlliancesAllianceIdContacts(int $allianceId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/alliances/{alliance_id}/contacts', ['alliance_id' => $allianceId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => AlliancesAllianceIdContactsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getAlliancesAllianceIdContacts'] ?? null);
    }

    /**
     * @return EsiResult<array<AlliancesAllianceIdContactsLabelsGetItem>>
     * @scope esi-alliances.read_contacts.v1
     */
    public function getAlliancesAllianceIdContactsLabels(int $allianceId): EsiResult
    {
        $response = $this->transport->invoke('get', '/alliances/{alliance_id}/contacts/labels', ['alliance_id' => $allianceId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => AlliancesAllianceIdContactsLabelsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getAlliancesAllianceIdContactsLabels'] ?? null);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-characters.write_contacts.v1
     */
    public function deleteCharactersCharacterIdContacts(int $characterId, array $contactIds): EsiResult
    {
        $response = $this->transport->invoke('delete', '/characters/{character_id}/contacts', ['character_id' => $characterId], ['contact_ids' => $contactIds], []);
        return EsiResult::fromRaw($response, null, static::OPERATION_META['deleteCharactersCharacterIdContacts'] ?? null);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdContactsGetItem>>
     * @scope esi-characters.read_contacts.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdContacts(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/contacts', ['character_id' => $characterId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdContactsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdContacts'] ?? null);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-characters.write_contacts.v1
     */
    public function postCharactersCharacterIdContacts(mixed $requestBody, int $characterId, float $standing, ?array $labelIds = null, ?bool $watched = null): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/contacts', ['character_id' => $characterId], ['label_ids' => $labelIds, 'standing' => $standing, 'watched' => $watched], (array) $requestBody);
        return EsiResult::fromRaw($response, null, static::OPERATION_META['postCharactersCharacterIdContacts'] ?? null);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-characters.write_contacts.v1
     */
    public function putCharactersCharacterIdContacts(mixed $requestBody, int $characterId, float $standing, ?array $labelIds = null, ?bool $watched = null): EsiResult
    {
        $response = $this->transport->invoke('put', '/characters/{character_id}/contacts', ['character_id' => $characterId], ['label_ids' => $labelIds, 'standing' => $standing, 'watched' => $watched], (array) $requestBody);
        return EsiResult::fromRaw($response, null, static::OPERATION_META['putCharactersCharacterIdContacts'] ?? null);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdContactsLabelsGetItem>>
     * @scope esi-characters.read_contacts.v1
     */
    public function getCharactersCharacterIdContactsLabels(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/contacts/labels', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdContactsLabelsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdContactsLabels'] ?? null);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdContactsGetItem>>
     * @scope esi-corporations.read_contacts.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdContacts(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/contacts', ['corporation_id' => $corporationId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdContactsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCorporationsCorporationIdContacts'] ?? null);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdContactsLabelsGetItem>>
     * @scope esi-corporations.read_contacts.v1
     */
    public function getCorporationsCorporationIdContactsLabels(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/contacts/labels', ['corporation_id' => $corporationId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdContactsLabelsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCorporationsCorporationIdContactsLabels'] ?? null);
    }
}
