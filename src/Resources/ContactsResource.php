<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\AlliancesAllianceIdContactsGetItem;
use Seatplus\EsiSchema\Operations\Contacts\GetAlliancesAllianceIdContacts;
use Seatplus\EsiSchema\Responses\AlliancesAllianceIdContactsLabelsGetItem;
use Seatplus\EsiSchema\Operations\Contacts\GetAlliancesAllianceIdContactsLabels;
use Seatplus\EsiSchema\Operations\Contacts\DeleteCharactersCharacterIdContacts;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdContactsGetItem;
use Seatplus\EsiSchema\Operations\Contacts\GetCharactersCharacterIdContacts;
use Seatplus\EsiSchema\Operations\Contacts\PostCharactersCharacterIdContacts;
use Seatplus\EsiSchema\Operations\Contacts\PutCharactersCharacterIdContacts;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdContactsLabelsGetItem;
use Seatplus\EsiSchema\Operations\Contacts\GetCharactersCharacterIdContactsLabels;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdContactsGetItem;
use Seatplus\EsiSchema\Operations\Contacts\GetCorporationsCorporationIdContacts;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdContactsLabelsGetItem;
use Seatplus\EsiSchema\Operations\Contacts\GetCorporationsCorporationIdContactsLabels;

/**
 * ESI tag: Contacts
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class ContactsResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getAlliancesAllianceIdContacts' => GetAlliancesAllianceIdContacts::meta(),
            'getAlliancesAllianceIdContactsLabels' => GetAlliancesAllianceIdContactsLabels::meta(),
            'deleteCharactersCharacterIdContacts' => DeleteCharactersCharacterIdContacts::meta(),
            'getCharactersCharacterIdContacts' => GetCharactersCharacterIdContacts::meta(),
            'postCharactersCharacterIdContacts' => PostCharactersCharacterIdContacts::meta(),
            'putCharactersCharacterIdContacts' => PutCharactersCharacterIdContacts::meta(),
            'getCharactersCharacterIdContactsLabels' => GetCharactersCharacterIdContactsLabels::meta(),
            'getCorporationsCorporationIdContacts' => GetCorporationsCorporationIdContacts::meta(),
            'getCorporationsCorporationIdContactsLabels' => GetCorporationsCorporationIdContactsLabels::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getAlliancesAllianceIdContacts. Equivalent to GetAlliancesAllianceIdContacts::meta(). */
    public static function getAlliancesAllianceIdContactsMeta(): OperationMeta
    {
        return GetAlliancesAllianceIdContacts::meta();
    }

    /** Pre-call metadata for getAlliancesAllianceIdContactsLabels. Equivalent to GetAlliancesAllianceIdContactsLabels::meta(). */
    public static function getAlliancesAllianceIdContactsLabelsMeta(): OperationMeta
    {
        return GetAlliancesAllianceIdContactsLabels::meta();
    }

    /** Pre-call metadata for deleteCharactersCharacterIdContacts. Equivalent to DeleteCharactersCharacterIdContacts::meta(). */
    public static function deleteCharactersCharacterIdContactsMeta(): OperationMeta
    {
        return DeleteCharactersCharacterIdContacts::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdContacts. Equivalent to GetCharactersCharacterIdContacts::meta(). */
    public static function getCharactersCharacterIdContactsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdContacts::meta();
    }

    /** Pre-call metadata for postCharactersCharacterIdContacts. Equivalent to PostCharactersCharacterIdContacts::meta(). */
    public static function postCharactersCharacterIdContactsMeta(): OperationMeta
    {
        return PostCharactersCharacterIdContacts::meta();
    }

    /** Pre-call metadata for putCharactersCharacterIdContacts. Equivalent to PutCharactersCharacterIdContacts::meta(). */
    public static function putCharactersCharacterIdContactsMeta(): OperationMeta
    {
        return PutCharactersCharacterIdContacts::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdContactsLabels. Equivalent to GetCharactersCharacterIdContactsLabels::meta(). */
    public static function getCharactersCharacterIdContactsLabelsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdContactsLabels::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdContacts. Equivalent to GetCorporationsCorporationIdContacts::meta(). */
    public static function getCorporationsCorporationIdContactsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdContacts::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdContactsLabels. Equivalent to GetCorporationsCorporationIdContactsLabels::meta(). */
    public static function getCorporationsCorporationIdContactsLabelsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdContactsLabels::meta();
    }

    /**
     * @return EsiResult<array<AlliancesAllianceIdContactsGetItem>>
     * @scope esi-alliances.read_contacts.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getAlliancesAllianceIdContacts(int $allianceId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/alliances/{alliance_id}/contacts', ['alliance_id' => $allianceId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => AlliancesAllianceIdContactsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetAlliancesAllianceIdContacts::meta(),
        );
    }

    /**
     * @return EsiResult<array<AlliancesAllianceIdContactsLabelsGetItem>>
     * @scope esi-alliances.read_contacts.v1
     */
    public function getAlliancesAllianceIdContactsLabels(int $allianceId): EsiResult
    {
        $response = $this->transport->invoke('get', '/alliances/{alliance_id}/contacts/labels', ['alliance_id' => $allianceId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => AlliancesAllianceIdContactsLabelsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetAlliancesAllianceIdContactsLabels::meta(),
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-characters.write_contacts.v1
     */
    public function deleteCharactersCharacterIdContacts(int $characterId, array $contactIds): EsiResult
    {
        $response = $this->transport->invoke('delete', '/characters/{character_id}/contacts', ['character_id' => $characterId], ['contact_ids' => $contactIds], []);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: DeleteCharactersCharacterIdContacts::meta(),
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdContactsGetItem>>
     * @scope esi-characters.read_contacts.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdContacts(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/contacts', ['character_id' => $characterId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdContactsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdContacts::meta(),
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-characters.write_contacts.v1
     */
    public function postCharactersCharacterIdContacts(mixed $requestBody, int $characterId, float $standing, ?array $labelIds = null, ?bool $watched = null): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/contacts', ['character_id' => $characterId], ['label_ids' => $labelIds, 'standing' => $standing, 'watched' => $watched], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostCharactersCharacterIdContacts::meta(),
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-characters.write_contacts.v1
     */
    public function putCharactersCharacterIdContacts(mixed $requestBody, int $characterId, float $standing, ?array $labelIds = null, ?bool $watched = null): EsiResult
    {
        $response = $this->transport->invoke('put', '/characters/{character_id}/contacts', ['character_id' => $characterId], ['label_ids' => $labelIds, 'standing' => $standing, 'watched' => $watched], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PutCharactersCharacterIdContacts::meta(),
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdContactsLabelsGetItem>>
     * @scope esi-characters.read_contacts.v1
     */
    public function getCharactersCharacterIdContactsLabels(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/contacts/labels', ['character_id' => $characterId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdContactsLabelsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdContactsLabels::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdContactsGetItem>>
     * @scope esi-corporations.read_contacts.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdContacts(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/contacts', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdContactsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdContacts::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdContactsLabelsGetItem>>
     * @scope esi-corporations.read_contacts.v1
     */
    public function getCorporationsCorporationIdContactsLabels(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/contacts/labels', ['corporation_id' => $corporationId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdContactsLabelsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdContactsLabels::meta(),
        );
    }
}
