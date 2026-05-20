<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FwLeaderboardsCorporationsGet extends AbstractEsiDto
{
    public function __construct(
        public readonly mixed $kills,
        public readonly mixed $victory_points,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            kills: ($data->kills ?? null),
            victory_points: ($data->victory_points ?? null),
        );
    }
}
