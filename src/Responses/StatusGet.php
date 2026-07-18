<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class StatusGet extends AbstractEsiDto
{
    public function __construct(
        public readonly int $players,
        public readonly string $server_version,
        public readonly string $start_time,
        public readonly ?bool $vip = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            players: (int) ($data->players ?? 0),
            server_version: (string) ($data->server_version ?? ''),
            start_time: (string) ($data->start_time ?? ''),
            vip: $data->vip ?? null,
        );
    }
}
