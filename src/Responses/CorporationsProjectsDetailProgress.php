<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailProgress extends AbstractEsiDto
{
    public function __construct(
        public readonly int $current,
        public readonly int $desired,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            current: (int) ($data->current ?? 0),
            desired: (int) ($data->desired ?? 0),
        );
    }
}
