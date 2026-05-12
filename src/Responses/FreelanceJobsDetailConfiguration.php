<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FreelanceJobsDetailConfiguration extends AbstractEsiDto
{
    public function __construct(
        public readonly string $method,
        public readonly mixed $parameters,
        public readonly int $version,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            method: (string) ($data->method ?? ''),
            parameters: ($data->parameters ?? null),
            version: (int) ($data->version ?? 0),
        );
    }
}