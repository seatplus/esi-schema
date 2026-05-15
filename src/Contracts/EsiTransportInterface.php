<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Contracts;

/**
 * Minimal contract that any ESI transport must satisfy.
 *
 * Generated Resources depend only on this interface, not on any concrete
 * HTTP client, allowing the transport to be swapped freely.
 *
 * @see \Seatplus\EsiClient\EsiClient — reference implementation
 */
interface EsiTransportInterface
{
    /**
     * @param  array<string, mixed>  $pathValues
     * @param  array<string, mixed>  $queryParams
     * @param  array<mixed>          $requestBody
     */
    public function invoke(
        string $method,
        string $path,
        array $pathValues = [],
        array $queryParams = [],
        array $requestBody = [],
    ): EsiRawResponse;

    /**
     * Assert that the current authentication context possesses the given OAuth2 scope.
     *
     * Pass null for public (unauthenticated) endpoints — implementations MUST treat
     * null as a no-op and return without throwing.
     *
     * @throws ScopeAccessDeniedException When $scope is non-null and the token lacks it.
     */
    public function assertScope(?string $scope): void;
}
