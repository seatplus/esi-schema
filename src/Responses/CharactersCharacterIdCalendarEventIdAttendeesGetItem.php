<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdCalendarEventIdAttendeesGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly ?int $character_id = null,
        public readonly ?string $event_response = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            character_id: $data->character_id ?? null,
            event_response: $data->event_response ?? null,
        );
    }
}
