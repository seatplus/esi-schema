<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdCalendarGetItem;

/**
 * ESI operation: getCharactersCharacterIdCalendar
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdCalendar implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 5, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-calendar.read_calendar_events.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdCalendarGetItem>>
     * @scope esi-calendar.read_calendar_events.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, ?int $fromEvent = null): EsiResult
    {
        $response = $transport->invoke('get', '/characters/{character_id}/calendar', ['character_id' => $characterId], ['from_event' => $fromEvent]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdCalendarGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
