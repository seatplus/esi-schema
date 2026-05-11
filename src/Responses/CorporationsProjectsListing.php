<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsProjectsListing extends AbstractEsiDto
{
    public function __construct(
        public readonly array $projects,
        public readonly ?Cursor $cursor = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            projects: array_map(fn (object $i) => CorporationsProjectsDetailProject::from($i), (array) ($data->projects ?? [])),
            cursor: isset($data->cursor) ? Cursor::from($data->cursor) : null,
        );
    }
}
