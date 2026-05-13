<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Contracts;

/**
 * Cursor tokens for cursor-based pagination.
 * Returned by ESI endpoints that use x-pagination: cursor.
 *
 * Use $before to page backwards (older records),
 * Use $after  to page forwards  (newer records / detect new data).
 */
final readonly class EsiCursor
{
    public function __construct(
        public readonly ?string $before = null,
        public readonly ?string $after = null,
    ) {
    }
}
