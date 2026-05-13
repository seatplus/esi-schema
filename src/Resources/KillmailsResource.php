<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdKillmailsRecentGetItem;
use Seatplus\EsiSchema\Operations\Killmails\GetCharactersCharacterIdKillmailsRecent;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdKillmailsRecentGetItem;
use Seatplus\EsiSchema\Operations\Killmails\GetCorporationsCorporationIdKillmailsRecent;
use Seatplus\EsiSchema\Responses\KillmailsKillmailIdKillmailHashGet;
use Seatplus\EsiSchema\Operations\Killmails\GetKillmailsKillmailIdKillmailHash;

/**
 * ESI tag: Killmails
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class KillmailsResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdKillmailsRecent' => GetCharactersCharacterIdKillmailsRecent::meta(),
            'getCorporationsCorporationIdKillmailsRecent' => GetCorporationsCorporationIdKillmailsRecent::meta(),
            'getKillmailsKillmailIdKillmailHash' => GetKillmailsKillmailIdKillmailHash::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdKillmailsRecent. Equivalent to GetCharactersCharacterIdKillmailsRecent::meta(). */
    public static function getCharactersCharacterIdKillmailsRecentMeta(): OperationMeta
    {
        return GetCharactersCharacterIdKillmailsRecent::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdKillmailsRecent. Equivalent to GetCorporationsCorporationIdKillmailsRecent::meta(). */
    public static function getCorporationsCorporationIdKillmailsRecentMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdKillmailsRecent::meta();
    }

    /** Pre-call metadata for getKillmailsKillmailIdKillmailHash. Equivalent to GetKillmailsKillmailIdKillmailHash::meta(). */
    public static function getKillmailsKillmailIdKillmailHashMeta(): OperationMeta
    {
        return GetKillmailsKillmailIdKillmailHash::meta();
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdKillmailsRecentGetItem>>
     * @scope esi-killmails.read_killmails.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdKillmailsRecent(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/killmails/recent', ['character_id' => $characterId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdKillmailsRecentGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdKillmailsRecent::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdKillmailsRecentGetItem>>
     * @scope esi-killmails.read_corporation_killmails.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdKillmailsRecent(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/killmails/recent', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdKillmailsRecentGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdKillmailsRecent::meta(),
        );
    }

    /**
     * @return KillmailsKillmailIdKillmailHashGet
     */
    public function getKillmailsKillmailIdKillmailHash(string $killmailHash, int $killmailId): KillmailsKillmailIdKillmailHashGet
    {
        $response = $this->transport->invoke('get', '/killmails/{killmail_id}/{killmail_hash}', ['killmail_hash' => $killmailHash, 'killmail_id' => $killmailId], []);
        $dto = KillmailsKillmailIdKillmailHashGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetKillmailsKillmailIdKillmailHash::meta();
        return $dto;
    }
}
