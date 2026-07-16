<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdCalendarGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly ?string $event_date = null,
        public readonly ?int $event_id = null,
        public readonly ?string $event_response = null,
        public readonly ?int $importance = null,
        public readonly ?string $title = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            event_date: $data->event_date ?? null,
            event_id: $data->event_id ?? null,
            event_response: $data->event_response ?? null,
            importance: $data->importance ?? null,
            title: $data->title ?? null,
        );
    }
}
