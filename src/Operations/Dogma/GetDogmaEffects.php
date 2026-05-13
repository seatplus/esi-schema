<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Dogma;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;

/**
 * ESI operation: getDogmaEffects
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetDogmaEffects implements EsiOperationInterface
{
    /** Required OAuth2 scope. Null for public endpoints. */
    public const ?string REQUIRED_SCOPE = null;

    /** Rate-limit group name (e.g. 'char-asset'). Null when not rate-limited. */
    public const ?string RATE_LIMIT_GROUP = null;

    /** Maximum token bucket size for this rate-limit group. */
    public const ?int RATE_LIMIT_MAX_TOKENS = null;

    /** Rate-limit window duration (e.g. '15m'). */
    public const ?string RATE_LIMIT_WINDOW = null;

    /** Cache TTL in seconds. Null for non-cached endpoints. */
    public const ?int CACHE_AGE = null;

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
     * @return EsiResult<array<int>>
     */
    public static function execute(EsiTransportInterface $transport): EsiResult
    {
        $response = $transport->invoke('get', '/dogma/effects', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, self::meta());
    }
}
