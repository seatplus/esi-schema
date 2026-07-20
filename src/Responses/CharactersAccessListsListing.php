<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersAccessListsListing extends AbstractEsiDto
{
    public function __construct(
        public readonly array $access_lists,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            access_lists: array_map(fn (object $i) => CharactersAccessListsListingAccesslist::from($i), (array) ($data->access_lists ?? [])),
        );
    }
}
