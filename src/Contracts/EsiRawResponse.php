<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Contracts;

/**
 * Transport-layer response — returned by EsiTransportInterface::invoke().
 * Carries the raw decoded payload plus HTTP metadata set by the transport.
 *
 * Static rate-limit quota (max-tokens/window) lives on the generated Resource
 * class via rateLimit(). The per-request consumed/remaining values are here.
 */
final readonly class EsiRawResponse
{
    public function __construct(
        public readonly mixed $data,
        public readonly bool $isCachedLoad = false,
        public readonly int $pages = 1,
        /** Cursor tokens for cursor-based pagination (x-pagination: cursor routes). */
        public readonly ?EsiCursor $cursor = null,
        /** X-Ratelimit-Remaining — tokens remaining in current window. */
        public readonly ?int $rateLimitRemaining = null,
        /** X-Ratelimit-Used — tokens consumed by this specific request. */
        public readonly ?int $rateLimitUsed = null,
        /** Retry-After seconds — only set on 429 responses. */
        public readonly ?int $retryAfter = null,
        /** X-ESI-Error-Limit-Remain — errors left in this time frame. */
        public readonly ?int $errorLimitRemaining = null,
        /** X-ESI-Error-Limit-Reset — seconds left until next time frame and errors reset to zero. */
        public readonly ?int $errorLimitReset = null,
    ) {
    }
}
