<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailConfigurationunknown extends AbstractEsiDto
{
    public function __construct(
        public readonly mixed $data,
        public readonly string $type,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            data: ($data->data ?? null),
            type: (string) ($data->type ?? ''),
        );
    }
}
