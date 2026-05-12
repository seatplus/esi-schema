<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdKillmailsRecentGetItem;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdKillmailsRecentGetItem;
use Seatplus\EsiSchema\Responses\KillmailsKillmailIdKillmailHashGet;

/**
 * ESI tag: Killmails
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class KillmailsResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCharactersCharacterIdKillmailsRecent' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'char-killmail', 'max-tokens' => 30, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-killmails.read_killmails.v1'],
        'getCorporationsCorporationIdKillmailsRecent' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'corp-killmail', 'max-tokens' => 30, 'window-size' => '15m'], 'requiredRoles' => ['Director'], 'cursor' => false, 'requiredScope' => 'esi-killmails.read_corporation_killmails.v1'],
        'getKillmailsKillmailIdKillmailHash' => ['cacheAge' => 2592000, 'rateLimit' => ['group' => 'killmail', 'max-tokens' => 3600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
    ];

    /**
     * @return EsiResult<array<CharactersCharacterIdKillmailsRecentGetItem>>
     * @scope esi-killmails.read_killmails.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdKillmailsRecent(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/killmails/recent', ['character_id' => $characterId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdKillmailsRecentGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdKillmailsRecent'] ?? null);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdKillmailsRecentGetItem>>
     * @scope esi-killmails.read_corporation_killmails.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdKillmailsRecent(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/killmails/recent', ['corporation_id' => $corporationId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdKillmailsRecentGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCorporationsCorporationIdKillmailsRecent'] ?? null);
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
        $dto->operationMeta = static::OPERATION_META['getKillmailsKillmailIdKillmailHash'] ?? null;
        return $dto;
    }
}
