<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationCorporationIdMiningObserversGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly string $last_updated,
        public readonly int $observer_id,
        public readonly string $observer_type,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            last_updated: (string) ($data->last_updated ?? ''),
            observer_id: (int) ($data->observer_id ?? 0),
            observer_type: (string) ($data->observer_type ?? ''),
        );
    }
}