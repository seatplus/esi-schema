<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class MarketsRegionIdHistoryGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly float $average,
        public readonly string $date,
        public readonly float $highest,
        public readonly float $lowest,
        public readonly int $order_count,
        public readonly int $volume,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            average: (float) ($data->average ?? 0.0),
            date: (string) ($data->date ?? ''),
            highest: (float) ($data->highest ?? 0.0),
            lowest: (float) ($data->lowest ?? 0.0),
            order_count: (int) ($data->order_count ?? 0),
            volume: (int) ($data->volume ?? 0),
        );
    }
}
