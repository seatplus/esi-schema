<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdNotificationsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $notification_id,
        public readonly int $sender_id,
        public readonly string $sender_type,
        public readonly string $timestamp,
        public readonly string $type,
        public readonly ?bool $is_read = null,
        public readonly ?string $text = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            notification_id: (int) ($data->notification_id ?? 0),
            sender_id: (int) ($data->sender_id ?? 0),
            sender_type: (string) ($data->sender_type ?? ''),
            timestamp: (string) ($data->timestamp ?? ''),
            type: (string) ($data->type ?? ''),
            is_read: $data->is_read ?? null,
            text: $data->text ?? null,
        );
    }
}
