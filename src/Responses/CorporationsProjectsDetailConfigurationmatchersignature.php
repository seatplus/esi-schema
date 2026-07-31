<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailConfigurationmatchersignature extends AbstractEsiDto
{
    public function __construct(
        public readonly ?int $signature_type_id = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            signature_type_id: $data->signature_type_id ?? null,
        );
    }
}
