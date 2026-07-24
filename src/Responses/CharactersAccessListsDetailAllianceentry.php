<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersAccessListsDetailAllianceentry extends AbstractEsiDto
{
    public function __construct(
        public readonly string $access,
        public readonly int $alliance_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            access: (string) ($data->access ?? ''),
            alliance_id: (int) ($data->alliance_id ?? 0),
        );
    }
}
