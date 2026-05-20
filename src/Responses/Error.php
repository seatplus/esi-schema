<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class Error extends AbstractEsiDto
{
    public function __construct(
        public readonly string $error,
        public readonly ?array $details = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            error: (string) ($data->error ?? ''),
            details: isset($data->details) ? (array) $data->details : null,
        );
    }
}
