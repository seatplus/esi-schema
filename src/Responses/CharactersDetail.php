<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersDetail extends AbstractEsiDto
{
    public function __construct(
        public readonly int $achievement_score,
        public readonly string $birthday,
        public readonly int $bloodline_id,
        public readonly int $corporation_id,
        public readonly string $gender,
        public readonly string $name,
        public readonly int $race_id,
        public readonly ?int $alliance_id = null,
        public readonly ?string $character_title_id = null,
        public readonly ?string $corporation_title = null,
        public readonly ?string $description = null,
        public readonly ?int $faction_id = null,
        public readonly ?float $security_status = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            achievement_score: (int) ($data->achievement_score ?? 0),
            birthday: (string) ($data->birthday ?? ''),
            bloodline_id: (int) ($data->bloodline_id ?? 0),
            corporation_id: (int) ($data->corporation_id ?? 0),
            gender: (string) ($data->gender ?? ''),
            name: (string) ($data->name ?? ''),
            race_id: (int) ($data->race_id ?? 0),
            alliance_id: $data->alliance_id ?? null,
            character_title_id: $data->character_title_id ?? null,
            corporation_title: $data->corporation_title ?? null,
            description: $data->description ?? null,
            faction_id: $data->faction_id ?? null,
            security_status: $data->security_status ?? null,
        );
    }
}
