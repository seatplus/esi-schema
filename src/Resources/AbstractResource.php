<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;

/**
 * Base class for all generated ESI resource classes.
 *
 * Generated from ESI OpenAPI spec — do not edit manually.
 * Run bin/generate.php to regenerate.
 *
 * @phpstan-type OperationMetaArray array{
 *   cacheAge: int|null,
 *   rateLimit: array{group: string, max-tokens: int, window-size: string}|null,
 *   requiredRoles: list<string>,
 *   cursor: bool,
 *   requiredScope: string|null,
 * }
 */
abstract class AbstractResource
{
    /** @var array<string, OperationMetaArray> */
    protected const array OPERATION_META = [];

    public function __construct(
        protected readonly EsiTransportInterface $transport,
    ) {
    }

    /**
     * Return typed ESI spec metadata for a specific operation.
     *
     * Use this for pre-call introspection (e.g. checking required scope or
     * corporation roles before dispatching a job). For post-call access, the
     * result object exposes the same methods directly: $result->rateLimitGroup(),
     * $result->requiredScope(), etc.
     *
     * Returns safe defaults (all null / empty / false) for unknown operationIds.
     *
     * @example
     *   $meta = AssetsResource::metaFor('getCharactersCharacterIdAssets');
     *   $meta->requiredScope();            // 'esi-assets.read_assets.v1'
     *   $meta->tokenSatisfies($scopes);    // true/false
     *   $meta->rateLimitGroup();           // 'char-asset'
     */
    public static function metaFor(string $operationId): OperationMeta
    {
        return OperationMeta::from(static::OPERATION_META[$operationId] ?? null);
    }
}
