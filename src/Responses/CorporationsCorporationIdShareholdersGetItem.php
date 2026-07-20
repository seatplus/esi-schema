<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsCorporationIdShareholdersGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $share_count,
        public readonly int $shareholder_id,
        public readonly string $shareholder_type,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            share_count: (int) ($data->share_count ?? 0),
            shareholder_id: (int) ($data->shareholder_id ?? 0),
            shareholder_type: (string) ($data->shareholder_type ?? ''),
        );
    }
}
