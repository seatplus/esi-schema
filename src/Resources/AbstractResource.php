<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;

/**
 * Base class for all generated ESI resource classes.
 *
 * Generated from ESI OpenAPI spec — do not edit manually.
 * Run bin/generate.php to regenerate.
 *
 * @phpstan-type OperationMeta array{
 *   cacheAge: int|null,
 *   rateLimit: array{group: string, max-tokens: int, window-size: string}|null,
 *   requiredRoles: list<string>,
 *   cursor: bool,
 * }
 */
abstract class AbstractResource
{
    /** @var array<string, OperationMeta> */
    protected const array OPERATION_META = [];

    public function __construct(
        protected readonly EsiTransportInterface $transport,
    ) {
    }

    /**
     * Return all ESI spec metadata for a specific operation.
     *
     * - cacheAge:      Expected cache TTL in seconds (null = no-cache endpoint).
     * - rateLimit:     Rate-limit bucket definition from the spec.
     * - requiredRoles: EVE corporation roles required for this endpoint.
     * - cursor:        True if this endpoint uses cursor-based pagination.
     *
     * @return OperationMeta
     */
    public static function metaFor(string $operationId): array
    {
        return static::OPERATION_META[$operationId] ?? [
            'cacheAge'      => null,
            'rateLimit'     => null,
            'requiredRoles' => [],
            'cursor'        => false,
        ];
    }

    /**
     * Expected cache TTL in seconds for this operation.
     * Returns null for event-based or no-cache endpoints.
     */
    public static function cacheAge(string $operationId): ?int
    {
        return static::metaFor($operationId)['cacheAge'];
    }

    /**
     * EVE corporation roles required for this operation (e.g. ['Director']).
     * Empty array means no in-game corporation role is required.
     *
     * @return list<string>
     */
    public static function requiredRoles(string $operationId): array
    {
        return static::metaFor($operationId)['requiredRoles'];
    }

    /**
     * True if this operation uses cursor-based pagination (x-pagination: cursor).
     * Cursor tokens are returned in EsiRawResponse::$cursor after each call.
     */
    public static function usesCursor(string $operationId): bool
    {
        return static::metaFor($operationId)['cursor'];
    }

    /**
     * Rate-limit group name for this operation (e.g. 'char-asset').
     * Returns null for operations with no rate-limit group in the spec.
     */
    public static function rateLimitGroup(string $operationId): ?string
    {
        return static::metaFor($operationId)['rateLimit']['group'] ?? null;
    }

    /**
     * Maximum token count for the rate-limit bucket (e.g. 1800 for 'char-asset').
     * Returns null for operations with no rate-limit in the spec.
     */
    public static function rateLimitMaxTokens(string $operationId): ?int
    {
        return static::metaFor($operationId)['rateLimit']['max-tokens'] ?? null;
    }

    /**
     * Rate-limit window duration as a human-readable string (e.g. '15m').
     * Returns null for operations with no rate-limit in the spec.
     */
    public static function rateLimitWindow(string $operationId): ?string
    {
        return static::metaFor($operationId)['rateLimit']['window-size'] ?? null;
    }
}
