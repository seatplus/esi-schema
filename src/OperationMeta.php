<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema;

use Seatplus\EsiSchema\Concerns\HasOperationMeta;

/**
 * Typed ESI spec metadata for a single operation.
 *
 * Returned by AbstractResource::metaFor() for pre-call introspection.
 * Exposes the same accessors as post-call result objects (EsiResult / AbstractEsiDto).
 *
 * @example
 *   $meta = AssetsResource::metaFor('getCharactersCharacterIdAssets');
 *   $meta->requiredScope();            // 'esi-assets.read_assets.v1'
 *   $meta->rateLimitGroup();           // 'char-asset'
 *   $meta->tokenSatisfies($scopes);    // true/false
 */
final readonly class OperationMeta
{
    use HasOperationMeta;

    /** @param array<string,mixed>|null $operationMeta */
    private function __construct(
        private ?array $operationMeta,
    ) {
    }

    /**
     * Build an OperationMeta from a raw OPERATION_META array entry.
     * Pass null (or an empty / missing entry) to get safe defaults.
     *
     * @param array<string,mixed>|null $raw
     */
    public static function from(?array $raw): self
    {
        return new self($raw);
    }

    /**
     * Check whether a set of token scopes satisfies this operation's requirement.
     *
     * Returns true when:
     *  - the endpoint is public (requiredScope() === null), OR
     *  - the required scope is present in the provided list.
     *
     * Typical usage before dispatching an ESI job:
     * ```php
     * $meta = AssetsResource::metaFor('getCharactersCharacterIdAssets');
     * if (! $meta->tokenSatisfies($refreshToken->scopes)) {
     *     throw new MissingScopeException($meta->requiredScope());
     * }
     * ```
     *
     * @param list<string> $scopes Token scopes, e.g. from RefreshToken::$scopes
     */
    public function tokenSatisfies(array $scopes): bool
    {
        $required = $this->requiredScope();

        return $required === null || in_array($required, $scopes, strict: true);
    }

    /**
     * Return the raw underlying metadata array.
     *
     * Used internally by generated operation classes to pass metadata
     * to EsiResult::fromRaw() and AbstractEsiDto.
     *
     * @return array<string,mixed>|null
     */
    public function raw(): ?array
    {
        return $this->operationMeta;
    }
}
