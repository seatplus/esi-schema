<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsCorporationIdMembersTitlesGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $character_id,
        public readonly array $titles,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            character_id: (int) ($data->character_id ?? 0),
            titles: (array) ($data->titles ?? []),
        );
    }
}
