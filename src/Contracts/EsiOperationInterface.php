<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Contracts;

use Seatplus\EsiSchema\OperationMeta;

/**
 * Contract for generated per-route ESI operation classes.
 *
 * Each ESI endpoint is represented by a single generated class in
 * src/Operations/ that implements this interface. The class name is the
 * PascalCase operationId (e.g. GetCharactersCharacterIdAssets).
 *
 * Implementing classes also provide a typed static execute() method whose
 * signature matches the specific endpoint's parameters and return type —
 * that method is not part of this interface because its signature varies.
 */
interface EsiOperationInterface
{
    /**
     * Return the spec metadata for this operation.
     *
     * Use before dispatching an ESI job to check required scope, rate-limit
     * group, cache TTL, and corporation roles — without making any HTTP call.
     *
     * @example
     *   GetCharactersCharacterIdAssets::meta()->requiredScope()
     *   GetCharactersCharacterIdAssets::meta()->requiredScope
     */
    public static function meta(): OperationMeta;
}
