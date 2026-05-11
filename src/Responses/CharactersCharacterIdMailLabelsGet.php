<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdMailLabelsGet extends AbstractEsiDto
{
    public function __construct(
        public readonly ?array $labels = null,
        public readonly ?int $total_unread_count = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            labels: isset($data->labels) ? (array) $data->labels : null,
            total_unread_count: $data->total_unread_count ?? null,
        );
    }
}
