<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdCalendarGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdCalendarEventIdGet;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdCalendarEventIdAttendeesGetItem;

/**
 * ESI tag: Calendar
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class CalendarResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCharactersCharacterIdCalendar' => ['cacheAge' => 5, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-calendar.read_calendar_events.v1'],
        'getCharactersCharacterIdCalendarEventId' => ['cacheAge' => 5, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-calendar.read_calendar_events.v1'],
        'putCharactersCharacterIdCalendarEventId' => ['cacheAge' => 5, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-calendar.respond_calendar_events.v1'],
        'getCharactersCharacterIdCalendarEventIdAttendees' => ['cacheAge' => 600, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-calendar.read_calendar_events.v1'],
    ];

    /**
     * @return EsiResult<array<CharactersCharacterIdCalendarGetItem>>
     * @scope esi-calendar.read_calendar_events.v1
     */
    public function getCharactersCharacterIdCalendar(int $characterId, ?int $fromEvent = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/calendar', ['character_id' => $characterId], ['from_event' => $fromEvent]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdCalendarGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdCalendar'] ?? null);
    }

    /**
     * @return CharactersCharacterIdCalendarEventIdGet
     * @scope esi-calendar.read_calendar_events.v1
     */
    public function getCharactersCharacterIdCalendarEventId(int $characterId, int $eventId): CharactersCharacterIdCalendarEventIdGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/calendar/{event_id}', ['character_id' => $characterId, 'event_id' => $eventId], []);
        $dto = CharactersCharacterIdCalendarEventIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getCharactersCharacterIdCalendarEventId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<null>
     * @scope esi-calendar.respond_calendar_events.v1
     */
    public function putCharactersCharacterIdCalendarEventId(mixed $requestBody, int $characterId, int $eventId): EsiResult
    {
        $response = $this->transport->invoke('put', '/characters/{character_id}/calendar/{event_id}', ['character_id' => $characterId, 'event_id' => $eventId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, null, static::OPERATION_META['putCharactersCharacterIdCalendarEventId'] ?? null);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdCalendarEventIdAttendeesGetItem>>
     * @scope esi-calendar.read_calendar_events.v1
     */
    public function getCharactersCharacterIdCalendarEventIdAttendees(int $characterId, int $eventId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/calendar/{event_id}/attendees', ['character_id' => $characterId, 'event_id' => $eventId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdCalendarEventIdAttendeesGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdCalendarEventIdAttendees'] ?? null);
    }
}
