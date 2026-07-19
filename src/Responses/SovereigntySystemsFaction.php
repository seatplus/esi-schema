<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class SovereigntySystemsFaction extends AbstractEsiDto
{
    public function __construct(
        public readonly int $faction_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            faction_id: (int) ($data->faction_id ?? 0),
        );
    }
}
