<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Contracts;

/**
 * Transport-layer response — returned by EsiTransportInterface::invoke().
 * Carries the raw decoded payload plus HTTP metadata set by the transport.
 */
final readonly class EsiRawResponse
{
    public function __construct(
        public readonly mixed $data,
        public readonly bool $isCachedLoad = false,
        public readonly int $pages = 1,
    ) {
    }
}
