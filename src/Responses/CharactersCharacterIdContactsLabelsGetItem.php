<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdContactsLabelsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $label_id,
        public readonly string $label_name,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            label_id: (int) ($data->label_id ?? 0),
            label_name: (string) ($data->label_name ?? ''),
        );
    }
}