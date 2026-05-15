<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Contracts;

/**
 * Thrown when an ESI operation requires an OAuth2 scope that the
 * current authentication token does not possess.
 *
 * This exception is declared in esi-schema so that any implementation
 * of EsiTransportInterface can share the same exception type across
 * package boundaries.
 */
class ScopeAccessDeniedException extends \RuntimeException
{
    public function __construct(string $requiredScope, string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(
            $message !== '' ? $message : "Missing required OAuth2 scope: {$requiredScope}",
            $code,
            $previous,
        );
    }
}
