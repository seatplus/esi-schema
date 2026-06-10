<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersMercenaryTacticalOperationsListingOperation extends AbstractEsiDto
{
    public function __construct(
        public readonly string $id,
        public readonly int $mercenary_den_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            id: (string) ($data->id ?? ''),
            mercenary_den_id: (int) ($data->mercenary_den_id ?? 0),
        );
    }
}
