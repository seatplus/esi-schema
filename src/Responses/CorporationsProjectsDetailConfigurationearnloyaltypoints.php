<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsDetailConfigurationearnloyaltypoints extends AbstractEsiDto
{
    public function __construct(
        public readonly ?array $corporations = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            corporations: isset($data->corporations) ? (array) $data->corporations : null,
        );
    }
}
