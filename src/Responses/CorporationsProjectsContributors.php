<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsContributors extends AbstractEsiDto
{
    public function __construct(
        public readonly array $contributors,
        public readonly ?Cursor $cursor = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            contributors: array_map(fn (object $i) => CorporationsProjectsContributorsContributor::from($i), (array) ($data->contributors ?? [])),
            cursor: isset($data->cursor) ? Cursor::from($data->cursor) : null,
        );
    }
}
