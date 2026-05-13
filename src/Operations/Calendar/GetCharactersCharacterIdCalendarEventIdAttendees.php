<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Calendar;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdCalendarEventIdAttendeesGetItem;

/**
 * ESI operation: getCharactersCharacterIdCalendarEventIdAttendees
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdCalendarEventIdAttendees implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 600, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-calendar.read_calendar_events.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdCalendarEventIdAttendeesGetItem>>
     * @scope esi-calendar.read_calendar_events.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, int $eventId): EsiResult
    {
        $response = $transport->invoke('get', '/characters/{character_id}/calendar/{event_id}/attendees', ['character_id' => $characterId, 'event_id' => $eventId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdCalendarEventIdAttendeesGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
