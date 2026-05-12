<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdLoyaltyPointsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $corporation_id,
        public readonly int $loyalty_points,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            corporation_id: (int) ($data->corporation_id ?? 0),
            loyalty_points: (int) ($data->loyalty_points ?? 0),
        );
    }
}