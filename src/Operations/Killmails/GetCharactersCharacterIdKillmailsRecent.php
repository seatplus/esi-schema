<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Killmails;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdKillmailsRecentGetItem;

/**
 * ESI operation: getCharactersCharacterIdKillmailsRecent
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdKillmailsRecent implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 300, 'rateLimit' => ['group' => 'char-killmail', 'max-tokens' => 30, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-killmails.read_killmails.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdKillmailsRecentGetItem>>
     * @scope esi-killmails.read_killmails.v1
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/characters/{character_id}/killmails/recent', ['character_id' => $characterId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdKillmailsRecentGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
