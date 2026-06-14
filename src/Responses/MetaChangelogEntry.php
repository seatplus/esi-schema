<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class MetaChangelogEntry extends AbstractEsiDto
{
    public function __construct(
        public readonly string $compatibility_date,
        public readonly string $description,
        public readonly string $method,
        public readonly string $path,
        public readonly string $type,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            compatibility_date: (string) ($data->compatibility_date ?? ''),
            description: (string) ($data->description ?? ''),
            method: (string) ($data->method ?? ''),
            path: (string) ($data->path ?? ''),
            type: (string) ($data->type ?? ''),
        );
    }
}
