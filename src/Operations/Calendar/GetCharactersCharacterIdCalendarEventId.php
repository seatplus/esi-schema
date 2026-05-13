<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Calendar;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdCalendarEventIdGet;

/**
 * ESI operation: getCharactersCharacterIdCalendarEventId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdCalendarEventId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 5, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-calendar.read_calendar_events.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CharactersCharacterIdCalendarEventIdGet
     * @scope esi-calendar.read_calendar_events.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, int $eventId): CharactersCharacterIdCalendarEventIdGet
    {
        $response = $transport->invoke('get', '/characters/{character_id}/calendar/{event_id}', ['character_id' => $characterId, 'event_id' => $eventId], []);
        $dto = CharactersCharacterIdCalendarEventIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
