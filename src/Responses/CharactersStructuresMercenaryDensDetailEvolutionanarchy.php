<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersStructuresMercenaryDensDetailEvolutionanarchy extends AbstractEsiDto
{
    public function __construct(
        public readonly int $amount,
        public readonly string $level,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            amount: (int) ($data->amount ?? 0),
            level: (string) ($data->level ?? ''),
        );
    }
}
