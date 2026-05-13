<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdClonesGet;
use Seatplus\EsiSchema\Operations\Clones\GetCharactersCharacterIdClones;
use Seatplus\EsiSchema\Operations\Clones\GetCharactersCharacterIdImplants;

/**
 * ESI tag: Clones
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class ClonesResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdClones' => GetCharactersCharacterIdClones::meta(),
            'getCharactersCharacterIdImplants' => GetCharactersCharacterIdImplants::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdClones. Equivalent to GetCharactersCharacterIdClones::meta(). */
    public static function getCharactersCharacterIdClonesMeta(): OperationMeta
    {
        return GetCharactersCharacterIdClones::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdImplants. Equivalent to GetCharactersCharacterIdImplants::meta(). */
    public static function getCharactersCharacterIdImplantsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdImplants::meta();
    }

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
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }
}
