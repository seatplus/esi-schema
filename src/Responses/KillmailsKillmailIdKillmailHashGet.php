<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class KillmailsKillmailIdKillmailHashGet extends AbstractEsiDto
{
    public function __construct(
        public readonly array $attackers,
        public readonly int $killmail_id,
        public readonly string $killmail_time,
        public readonly int $solar_system_id,
        public readonly mixed $victim,
        public readonly ?int $moon_id = null,
        public readonly ?int $war_id = null,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            attackers: (array) ($data->attackers ?? []),
            killmail_id: (int) ($data->killmail_id ?? 0),
            killmail_time: (string) ($data->killmail_time ?? ''),
            solar_system_id: (int) ($data->solar_system_id ?? 0),
            victim: ($data->victim ?? null),
            moon_id: $data->moon_id ?? null,
            war_id: $data->war_id ?? null,
        );
    }
}