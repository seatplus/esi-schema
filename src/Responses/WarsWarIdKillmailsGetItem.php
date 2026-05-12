<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class WarsWarIdKillmailsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly string $killmail_hash,
        public readonly int $killmail_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            killmail_hash: (string) ($data->killmail_hash ?? ''),
            killmail_id: (int) ($data->killmail_id ?? 0),
        );
    }
}
