<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Calendar\GetCharactersCharacterIdCalendar;
use Seatplus\EsiSchema\Resources\Calendar\GetCharactersCharacterIdCalendarEventId;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdCalendarEventIdGet;
use Seatplus\EsiSchema\Resources\Calendar\PutCharactersCharacterIdCalendarEventId;
use Seatplus\EsiSchema\Resources\Calendar\GetCharactersCharacterIdCalendarEventIdAttendees;

/**
 * ESI Calendar resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CalendarResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     * @scope esi-calendar.read_calendar_events.v1
     */
    public function getCharactersCharacterIdCalendar(int $characterId, ?int $fromEvent = null): EsiResult
    {
        return GetCharactersCharacterIdCalendar::execute($this->transport, $characterId, $fromEvent);
    }

    /**
     * @return CharactersCharacterIdCalendarEventIdGet
     * @scope esi-calendar.read_calendar_events.v1
     */
    public function getCharactersCharacterIdCalendarEventId(int $characterId, int $eventId): CharactersCharacterIdCalendarEventIdGet
    {
        return GetCharactersCharacterIdCalendarEventId::execute($this->transport, $characterId, $eventId);
    }

    /**
     * @return EsiResult
     * @scope esi-calendar.respond_calendar_events.v1
     */
    public function putCharactersCharacterIdCalendarEventId(mixed $requestBody, int $characterId, int $eventId): EsiResult
    {
        return PutCharactersCharacterIdCalendarEventId::execute($this->transport, $requestBody, $characterId, $eventId);
    }

    /**
     * @return EsiResult
     * @scope esi-calendar.read_calendar_events.v1
     */
    public function getCharactersCharacterIdCalendarEventIdAttendees(int $characterId, int $eventId): EsiResult
    {
        return GetCharactersCharacterIdCalendarEventIdAttendees::execute($this->transport, $characterId, $eventId);
    }
}
