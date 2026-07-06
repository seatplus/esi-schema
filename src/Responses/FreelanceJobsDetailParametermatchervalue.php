<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FreelanceJobsDetailParametermatchervalue extends AbstractEsiDto
{
    public function __construct(
        public readonly string $value_type,
        public readonly array $values,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            value_type: (string) ($data->value_type ?? ''),
            values: (array) ($data->values ?? []),
        );
    }
}
