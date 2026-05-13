<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Concerns;

use Seatplus\EsiSchema\OperationMeta;

/**
 * Typed accessor methods for ESI spec metadata on result objects.
 *
 * Mixed into EsiResult (array endpoints) and AbstractEsiDto (object endpoints)
 * to expose the same metadata accessors post-call that OperationMeta provides
 * pre-call.
 *
 * The using class must declare a public ?OperationMeta $operationMeta property.
 */
trait HasOperationMeta
{
    /**
     * Rate-limit group name for this operation (e.g. 'char-asset', 'corp-wallet').
     * Null for operations with no rate-limit group in the ESI spec.
     */
    public function rateLimitGroup(): ?string
    {
        return $this->operationMeta?->rateLimitGroup;
    }

    /**
     * Maximum token count for the rate-limit bucket (e.g. 1800).
     * Null for operations with no rate-limit in the spec.
     */
    public function rateLimitMaxTokens(): ?int
    {
        return $this->operationMeta?->rateLimitMaxTokens;
    }

    /**
     * Rate-limit window duration as a human-readable string (e.g. '15m').
     * Null for operations with no rate-limit in the spec.
     */
    public function rateLimitWindow(): ?string
    {
        return $this->operationMeta?->rateLimitWindow;
    }

    /**
     * Expected cache TTL in seconds for this operation.
     * Null for event-based or no-cache endpoints.
     */
    public function cacheAge(): ?int
    {
        return $this->operationMeta?->cacheAge;
    }

    /**
     * EVE corporation roles required for this operation (e.g. ['Director']).
     * Empty array means no in-game corporation role is required.
     *
     * @return list<string>
     */
    public function requiredRoles(): array
    {
        return $this->operationMeta !== null ? $this->operationMeta->requiredRoles : [];
    }

    /**
     * True if this operation uses cursor-based pagination (x-pagination: cursor).
     * Cursor tokens are in EsiRawResponse::$cursor after each call.
     */
    public function usesCursor(): bool
    {
        return $this->operationMeta !== null ? $this->operationMeta->usesCursor : false;
    }

    /**
     * Required OAuth2 scope for this operation (e.g. 'esi-assets.read_assets.v1').
     * Null for public endpoints that require no authentication.
     */
    public function requiredScope(): ?string
    {
        return $this->operationMeta?->requiredScope;
    }
}
