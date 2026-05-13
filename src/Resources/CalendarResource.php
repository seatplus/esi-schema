<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdCalendarGetItem;
use Seatplus\EsiSchema\Operations\Calendar\GetCharactersCharacterIdCalendar;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdCalendarEventIdGet;
use Seatplus\EsiSchema\Operations\Calendar\GetCharactersCharacterIdCalendarEventId;
use Seatplus\EsiSchema\Operations\Calendar\PutCharactersCharacterIdCalendarEventId;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdCalendarEventIdAttendeesGetItem;
use Seatplus\EsiSchema\Operations\Calendar\GetCharactersCharacterIdCalendarEventIdAttendees;

/**
 * ESI tag: Calendar
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class CalendarResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdCalendar' => GetCharactersCharacterIdCalendar::meta(),
            'getCharactersCharacterIdCalendarEventId' => GetCharactersCharacterIdCalendarEventId::meta(),
            'putCharactersCharacterIdCalendarEventId' => PutCharactersCharacterIdCalendarEventId::meta(),
            'getCharactersCharacterIdCalendarEventIdAttendees' => GetCharactersCharacterIdCalendarEventIdAttendees::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdCalendar. Equivalent to GetCharactersCharacterIdCalendar::meta(). */
    public static function getCharactersCharacterIdCalendarMeta(): OperationMeta
    {
        return GetCharactersCharacterIdCalendar::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdCalendarEventId. Equivalent to GetCharactersCharacterIdCalendarEventId::meta(). */
    public static function getCharactersCharacterIdCalendarEventIdMeta(): OperationMeta
    {
        return GetCharactersCharacterIdCalendarEventId::meta();
    }

    /** Pre-call metadata for putCharactersCharacterIdCalendarEventId. Equivalent to PutCharactersCharacterIdCalendarEventId::meta(). */
    public static function putCharactersCharacterIdCalendarEventIdMeta(): OperationMeta
    {
        return PutCharactersCharacterIdCalendarEventId::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdCalendarEventIdAttendees. Equivalent to GetCharactersCharacterIdCalendarEventIdAttendees::meta(). */
    public static function getCharactersCharacterIdCalendarEventIdAttendeesMeta(): OperationMeta
    {
        return GetCharactersCharacterIdCalendarEventIdAttendees::meta();
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdCalendarGetItem>>
     * @scope esi-calendar.read_calendar_events.v1
     */
    public function getCharactersCharacterIdCalendar(int $characterId, ?int $fromEvent = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/calendar', ['character_id' => $characterId], ['from_event' => $fromEvent]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdCalendarGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
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
        return $dto;
    }

    /**
     * @return EsiResult<null>
     * @scope esi-calendar.respond_calendar_events.v1
     */
    public function putCharactersCharacterIdCalendarEventId(mixed $requestBody, int $characterId, int $eventId): EsiResult
    {
        $response = $this->transport->invoke('put', '/characters/{character_id}/calendar/{event_id}', ['character_id' => $characterId, 'event_id' => $eventId], [], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdCalendarEventIdAttendeesGetItem>>
     * @scope esi-calendar.read_calendar_events.v1
     */
    public function getCharactersCharacterIdCalendarEventIdAttendees(int $characterId, int $eventId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/calendar/{event_id}/attendees', ['character_id' => $characterId, 'event_id' => $eventId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdCalendarEventIdAttendeesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }
}
