<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class ErrorDetail extends AbstractEsiDto
{
    public function __construct(
        public readonly ?string $location = null,
        public readonly ?string $message = null,
        public readonly mixed $value = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            location: $data->location ?? null,
            message: $data->message ?? null,
            value: $data->value ?? null,
        );
    }
}
