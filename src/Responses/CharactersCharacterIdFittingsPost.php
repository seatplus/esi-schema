<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdFittingsPost extends AbstractEsiDto
{
    public function __construct(
        public readonly int $fitting_id,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            fitting_id: (int) ($data->fitting_id ?? 0),
        );
    }
}