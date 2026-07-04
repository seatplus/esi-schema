<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsStructuresSovereigntyHubsDetailTransport extends AbstractEsiDto
{
    public function __construct(
        public readonly mixed $configuration,
        public readonly mixed $state,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            configuration: ($data->configuration ?? null),
            state: ($data->state ?? null),
        );
    }
}
