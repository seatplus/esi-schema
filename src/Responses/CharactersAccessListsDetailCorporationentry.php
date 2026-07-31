<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersAccessListsDetailCorporationentry extends AbstractEsiDto
{
    public function __construct(
        public readonly string $access,
        public readonly int $corporation_id,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            access: (string) ($data->access ?? ''),
            corporation_id: (int) ($data->corporation_id ?? 0),
        );
    }
}
