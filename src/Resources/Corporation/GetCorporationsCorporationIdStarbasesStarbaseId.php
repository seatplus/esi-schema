<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources\Corporation;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdStarbasesStarbaseIdGet;

/**
 * ESI operation: getCorporationsCorporationIdStarbasesStarbaseId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdStarbasesStarbaseId implements EsiOperationInterface
{
    /** Required OAuth2 scope. Null for public endpoints. */
    public const ?string REQUIRED_SCOPE = 'esi-corporations.read_starbases.v1';

    /** Rate-limit group name (e.g. 'char-asset'). Null when not rate-limited. */
    public const ?string RATE_LIMIT_GROUP = 'corp-structure';

    /** Maximum token bucket size for this rate-limit group. */
    public const ?int RATE_LIMIT_MAX_TOKENS = 300;

    /** Rate-limit window duration (e.g. '15m'). */
    public const ?string RATE_LIMIT_WINDOW = '15m';

    /** Cache TTL in seconds. Null for non-cached endpoints. */
    public const ?int CACHE_AGE = 3600;

    /**
     * EVE corporation roles required (e.g. ['Director']).
     *
     * @var list<string>
     */
    public const array REQUIRED_ROLES = ['Director'];

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
     * @return CorporationsCorporationIdStarbasesStarbaseIdGet
     * @scope esi-corporations.read_starbases.v1
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, int $starbaseId, int $systemId): CorporationsCorporationIdStarbasesStarbaseIdGet
    {
        $transport->assertScope(self::REQUIRED_SCOPE);
        $response = $transport->invoke('get', '/corporations/{corporation_id}/starbases/{starbase_id}', ['corporation_id' => $corporationId, 'starbase_id' => $starbaseId], ['system_id' => $systemId]);
        $dto = CorporationsCorporationIdStarbasesStarbaseIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->rateLimitRemaining = $response->rateLimitRemaining;
        return $dto;
    }
}
