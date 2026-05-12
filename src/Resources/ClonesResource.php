<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdClonesGet;

/**
 * ESI tag: Clones
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class ClonesResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCharactersCharacterIdClones' => ['cacheAge' => 120, 'rateLimit' => ['group' => 'char-location', 'max-tokens' => 1200, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCharactersCharacterIdImplants' => ['cacheAge' => 120, 'rateLimit' => ['group' => 'char-detail', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
    ];

    /**
     * @return CharactersCharacterIdClonesGet
     * @scope esi-clones.read_clones.v1
     */
    public function getCharactersCharacterIdClones(int $characterId): CharactersCharacterIdClonesGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/clones', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdClonesGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     * @scope esi-clones.read_implants.v1
     */
    public function getCharactersCharacterIdImplants(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/implants', ['character_id' => $characterId], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }
}
