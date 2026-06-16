<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdMailMailIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly ?string $body = null,
        public readonly ?int $from = null,
        public readonly ?array $labels = null,
        public readonly ?bool $read = null,
        public readonly ?array $recipients = null,
        public readonly ?string $subject = null,
        public readonly ?string $timestamp = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            body: $data->body ?? null,
            from: $data->from ?? null,
            labels: isset($data->labels) ? (array) $data->labels : null,
            read: $data->read ?? null,
            recipients: isset($data->recipients) ? (array) $data->recipients : null,
            subject: $data->subject ?? null,
            timestamp: $data->timestamp ?? null,
        );
    }
}
