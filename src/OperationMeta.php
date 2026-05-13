<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema;

/**
 * Typed ESI spec metadata for a single operation.
 *
 * Returned by Operation::meta() and Resource::metaFor() for pre-call introspection.
 * The same accessors are available post-call on EsiResult / AbstractEsiDto via
 * the HasOperationMeta trait.
 *
 * All constructor parameters have safe defaults (null / empty / false) so that
 * unknown or public endpoints can be represented with new OperationMeta().
 *
 * @example
 *   $meta = GetCharactersCharacterIdAssets::meta();
 *   $meta->requiredScope;              // 'esi-assets.read_assets.v1'
 *   $meta->rateLimitGroup;             // 'char-asset'
 *   $meta->rateLimitMaxTokens;         // 1800
 *   $meta->rateLimitWindow;            // '15m'
 */
final readonly class OperationMeta
{
    /**
     * @param list<string> $requiredRoles
     */
    public function __construct(
        /** Required OAuth2 scope, or null for public endpoints. */
        public readonly ?string $requiredScope = null,
        /** Rate-limit group name (e.g. 'char-asset'). Null when not rate-limited. */
        public readonly ?string $rateLimitGroup = null,
        /** Maximum token bucket size for this rate-limit group. */
        public readonly ?int $rateLimitMaxTokens = null,
        /** Rate-limit window duration as a string (e.g. '15m'). */
        public readonly ?string $rateLimitWindow = null,
        /** Cache TTL in seconds, or null for non-cached / event-based endpoints. */
        public readonly ?int $cacheAge = null,
        /** EVE corporation roles required (e.g. ['Director']). Empty for most endpoints. */
        public readonly array $requiredRoles = [],
        /** True for cursor-paginated endpoints (x-pagination: cursor). */
        public readonly bool $usesCursor = false,
    ) {
    }

}
