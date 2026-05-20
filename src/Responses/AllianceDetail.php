<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class AllianceDetail extends AbstractEsiDto
{
    public function __construct(
        public readonly int $creator_corporation_id,
        public readonly int $creator_id,
        public readonly string $date_founded,
        public readonly string $name,
        public readonly string $ticker,
        public readonly ?int $executor_corporation_id = null,
        public readonly ?int $faction_id = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            creator_corporation_id: (int) ($data->creator_corporation_id ?? 0),
            creator_id: (int) ($data->creator_id ?? 0),
            date_founded: (string) ($data->date_founded ?? ''),
            name: (string) ($data->name ?? ''),
            ticker: (string) ($data->ticker ?? ''),
            executor_corporation_id: $data->executor_corporation_id ?? null,
            faction_id: $data->faction_id ?? null,
        );
    }
}
