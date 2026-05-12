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
     * Use this for pre-call introspection (e.g. JobChecker checking required
     * roles before dispatching a job). For post-call access, use the result
     * object's own methods: $result->rateLimitGroup(), ->cacheAge(), etc.
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
}
