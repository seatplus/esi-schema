<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersAccessListsDetail extends AbstractEsiDto
{
    public function __construct(
        public readonly string $description,
        public readonly int $id,
        public readonly CharactersAccessListsDetailMembership $membership,
        public readonly string $name,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            description: (string) ($data->description ?? ''),
            id: (int) ($data->id ?? 0),
            membership: CharactersAccessListsDetailMembership::from($data->membership ?? new \stdClass()),
            name: (string) ($data->name ?? ''),
        );
    }
}
