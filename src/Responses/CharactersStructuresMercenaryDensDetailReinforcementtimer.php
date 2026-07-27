<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersStructuresMercenaryDensDetailReinforcementtimer extends AbstractEsiDto
{
    public function __construct(
        public readonly string $end,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            end: (string) ($data->end ?? ''),
        );
    }
}
