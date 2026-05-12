<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdNotificationsContactsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly string $message,
        public readonly int $notification_id,
        public readonly string $send_date,
        public readonly int $sender_character_id,
        public readonly float $standing_level,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            message: (string) ($data->message ?? ''),
            notification_id: (int) ($data->notification_id ?? 0),
            send_date: (string) ($data->send_date ?? ''),
            sender_character_id: (int) ($data->sender_character_id ?? 0),
            standing_level: (float) ($data->standing_level ?? 0.0),
        );
    }
}