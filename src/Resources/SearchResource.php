<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\Resources\Search\GetCharactersCharacterIdSearch;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdSearchGet;

/**
 * ESI Search resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class SearchResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return CharactersCharacterIdSearchGet
     * @scope esi-search.search_structures.v1
     */
    public function getCharactersCharacterIdSearch(array $categories, int $characterId, string $search, ?bool $strict = null): CharactersCharacterIdSearchGet
    {
        return GetCharactersCharacterIdSearch::execute($this->transport, $categories, $characterId, $search, $strict);
    }
}
