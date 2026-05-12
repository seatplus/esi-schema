<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdStandingsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $from_id,
        public readonly string $from_type,
        public readonly float $standing,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            from_id: (int) ($data->from_id ?? 0),
            from_type: (string) ($data->from_type ?? ''),
            standing: (float) ($data->standing ?? 0.0),
        );
    }
}
