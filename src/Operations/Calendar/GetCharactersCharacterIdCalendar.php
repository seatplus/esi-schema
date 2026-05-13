<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Calendar;

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
    /** Required OAuth2 scope. Null for public endpoints. */
    public const ?string REQUIRED_SCOPE = 'esi-calendar.read_calendar_events.v1';

    /** Rate-limit group name (e.g. 'char-asset'). Null when not rate-limited. */
    public const ?string RATE_LIMIT_GROUP = 'char-social';

    /** Maximum token bucket size for this rate-limit group. */
    public const ?int RATE_LIMIT_MAX_TOKENS = 600;

    /** Rate-limit window duration (e.g. '15m'). */
    public const ?string RATE_LIMIT_WINDOW = '15m';

    /** Cache TTL in seconds. Null for non-cached endpoints. */
    public const ?int CACHE_AGE = 5;

    /**
     * EVE corporation roles required (e.g. ['Director']).
     *
     * @var list<string>
     */
    public const array REQUIRED_ROLES = [];

    /** True for cursor-paginated endpoints. */
    public const bool USES_CURSOR = false;

    public static function meta(): OperationMeta
    {
        return new OperationMeta(
            requiredScope: self::REQUIRED_SCOPE,
            rateLimitGroup: self::RATE_LIMIT_GROUP,
            rateLimitMaxTokens: self::RATE_LIMIT_MAX_TOKENS,
            rateLimitWindow: self::RATE_LIMIT_WINDOW,
            cacheAge: self::CACHE_AGE,
            requiredRoles: self::REQUIRED_ROLES,
            usesCursor: self::USES_CURSOR,
        );
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
        ), self::meta());
    }
}
