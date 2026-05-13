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
 */
abstract class AbstractResource
{
    public function __construct(
        protected readonly EsiTransportInterface $transport,
    ) {
    }

    /**
     * Return typed ESI spec metadata for a specific operation by its operationId string.
     *
     * Use this for pre-call introspection when you only have the operationId as a string
     * (e.g. in middleware or logging). For direct access, prefer the typed companion method
     * on the concrete resource or the Operation class itself:
     *
     *   GetCharactersCharacterIdAssets::meta()                          // Operation class (preferred)
     *   AssetsResource::getCharactersCharacterIdAssetsMeta()            // Resource companion
     *
     * Returns a default OperationMeta (all nulls / empty) for unknown operationIds.
     *
     * @example
     *   $meta = AssetsResource::metaFor('getCharactersCharacterIdAssets');
     *   $meta->requiredScope;              // 'esi-assets.read_assets.v1'
     *   $meta->rateLimitGroup;             // 'char-asset'
     */
    abstract public static function metaFor(string $operationId): OperationMeta;
}
