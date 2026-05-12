<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Concerns;

/**
 * Typed accessors for ESI spec metadata baked into every result object.
 *
 * Both EsiResult (array endpoints) and AbstractEsiDto (object endpoints)
 * use this trait. The metadata is injected by generated Resource methods
 * from OPERATION_META at call time — no live spec fetch required.
 *
 * For pre-call introspection (e.g. JobChecker), use AbstractResource::metaFor().
 */
trait HasOperationMeta
{
    /**
     * Rate-limit group name for this operation (e.g. 'char-asset', 'corp-wallet').
     * Null for operations with no rate-limit group in the ESI spec.
     */
    public function rateLimitGroup(): ?string
    {
        return $this->operationMeta['rateLimit']['group'] ?? null;
    }

    /**
     * Maximum token count for the rate-limit bucket (e.g. 1800).
     * Null for operations with no rate-limit in the spec.
     */
    public function rateLimitMaxTokens(): ?int
    {
        return isset($this->operationMeta['rateLimit']['max-tokens'])
            ? (int) $this->operationMeta['rateLimit']['max-tokens']
            : null;
    }

    /**
     * Rate-limit window duration as a human-readable string (e.g. '15m').
     * Null for operations with no rate-limit in the spec.
     */
    public function rateLimitWindow(): ?string
    {
        return $this->operationMeta['rateLimit']['window-size'] ?? null;
    }

    /**
     * Expected cache TTL in seconds for this operation.
     * Null for event-based or no-cache endpoints.
     */
    public function cacheAge(): ?int
    {
        return isset($this->operationMeta['cacheAge'])
            ? (int) $this->operationMeta['cacheAge']
            : null;
    }

    /**
     * EVE corporation roles required for this operation (e.g. ['Director']).
     * Empty array means no in-game corporation role is required.
     *
     * @return list<string>
     */
    public function requiredRoles(): array
    {
        return $this->operationMeta['requiredRoles'] ?? [];
    }

    /**
     * True if this operation uses cursor-based pagination (x-pagination: cursor).
     * Cursor tokens are in EsiRawResponse::$cursor after each call.
     */
    public function usesCursor(): bool
    {
        return (bool) ($this->operationMeta['cursor'] ?? false);
    }
}
