<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class MetaNameEntry extends AbstractEsiDto
{
    public function __construct(
        public readonly string $date,
        public readonly string $name,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            date: (string) ($data->date ?? ''),
            name: (string) ($data->name ?? ''),
        );
    }
}
