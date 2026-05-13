<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdSearchGet;
use Seatplus\EsiSchema\Operations\Search\GetCharactersCharacterIdSearch;

/**
 * ESI tag: Search
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class SearchResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdSearch' => GetCharactersCharacterIdSearch::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdSearch. Equivalent to GetCharactersCharacterIdSearch::meta(). */
    public static function getCharactersCharacterIdSearchMeta(): OperationMeta
    {
        return GetCharactersCharacterIdSearch::meta();
    }

    /**
     * @return CharactersCharacterIdSearchGet
     * @scope esi-search.search_structures.v1
     */
    public function getCharactersCharacterIdSearch(array $categories, int $characterId, string $search, ?bool $strict = null): CharactersCharacterIdSearchGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/search', ['character_id' => $characterId], ['categories' => $categories, 'search' => $search, 'strict' => $strict]);
        $dto = CharactersCharacterIdSearchGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCharactersCharacterIdSearch::meta();
        return $dto;
    }
}
