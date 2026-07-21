<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class MetaName extends AbstractEsiDto
{
    public function __construct(
        public readonly string $current,
        public readonly array $history,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            current: (string) ($data->current ?? ''),
            history: array_map(fn (object $i) => MetaNameEntry::from($i), (array) ($data->history ?? [])),
        );
    }
}
