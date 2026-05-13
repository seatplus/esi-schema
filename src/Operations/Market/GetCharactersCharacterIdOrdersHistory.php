<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Market;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdOrdersHistoryGetItem;

/**
 * ESI operation: getCharactersCharacterIdOrdersHistory
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdOrdersHistory implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-markets.read_character_orders.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdOrdersHistoryGetItem>>
     * @scope esi-markets.read_character_orders.v1
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/characters/{character_id}/orders/history', ['character_id' => $characterId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdOrdersHistoryGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
