<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Search;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdSearchGet;

/**
 * ESI operation: getCharactersCharacterIdSearch
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdSearch implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-search.search_structures.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CharactersCharacterIdSearchGet
     * @scope esi-search.search_structures.v1
     */
    public static function execute(EsiTransportInterface $transport, array $categories, int $characterId, string $search, ?bool $strict = null): CharactersCharacterIdSearchGet
    {
        $response = $transport->invoke('get', '/characters/{character_id}/search', ['character_id' => $characterId], ['categories' => $categories, 'search' => $search, 'strict' => $strict]);
        $dto = CharactersCharacterIdSearchGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
