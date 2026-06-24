<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class AlliancesAllianceIdContactsGetItem extends AbstractEsiDto
{
    public function __construct(
        public readonly int $contact_id,
        public readonly string $contact_type,
        public readonly float $standing,
        public readonly ?array $label_ids = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            contact_id: (int) ($data->contact_id ?? 0),
            contact_type: (string) ($data->contact_type ?? ''),
            standing: (float) ($data->standing ?? 0.0),
            label_ids: isset($data->label_ids) ? (array) $data->label_ids : null,
        );
    }
}
