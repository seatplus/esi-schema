<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class WarsWarIdGet extends AbstractEsiDto
{
    public function __construct(
        public readonly mixed $aggressor,
        public readonly string $declared,
        public readonly mixed $defender,
        public readonly int $id,
        public readonly bool $mutual,
        public readonly bool $open_for_allies,
        public readonly ?array $allies = null,
        public readonly ?string $finished = null,
        public readonly ?string $retracted = null,
        public readonly ?string $started = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            aggressor: ($data->aggressor ?? null),
            declared: (string) ($data->declared ?? ''),
            defender: ($data->defender ?? null),
            id: (int) ($data->id ?? 0),
            mutual: (bool) ($data->mutual ?? false),
            open_for_allies: (bool) ($data->open_for_allies ?? false),
            allies: isset($data->allies) ? (array) $data->allies : null,
            finished: $data->finished ?? null,
            retracted: $data->retracted ?? null,
            started: $data->started ?? null,
        );
    }
}
