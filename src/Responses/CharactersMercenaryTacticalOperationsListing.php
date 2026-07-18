<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersMercenaryTacticalOperationsListing extends AbstractEsiDto
{
    public function __construct(
        public readonly array $operations,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            operations: array_map(fn (object $i) => CharactersMercenaryTacticalOperationsListingOperation::from($i), (array) ($data->operations ?? [])),
        );
    }
}
