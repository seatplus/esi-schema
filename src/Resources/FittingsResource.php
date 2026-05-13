<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFittingsGetItem;
use Seatplus\EsiSchema\Operations\Fittings\GetCharactersCharacterIdFittings;
use Seatplus\EsiSchema\Operations\Fittings\PostCharactersCharacterIdFittings;
use Seatplus\EsiSchema\Operations\Fittings\DeleteCharactersCharacterIdFittingsFittingId;

/**
 * ESI tag: Fittings
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class FittingsResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdFittings' => GetCharactersCharacterIdFittings::meta(),
            'postCharactersCharacterIdFittings' => PostCharactersCharacterIdFittings::meta(),
            'deleteCharactersCharacterIdFittingsFittingId' => DeleteCharactersCharacterIdFittingsFittingId::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdFittings. Equivalent to GetCharactersCharacterIdFittings::meta(). */
    public static function getCharactersCharacterIdFittingsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdFittings::meta();
    }

    /** Pre-call metadata for postCharactersCharacterIdFittings. Equivalent to PostCharactersCharacterIdFittings::meta(). */
    public static function postCharactersCharacterIdFittingsMeta(): OperationMeta
    {
        return PostCharactersCharacterIdFittings::meta();
    }

    /** Pre-call metadata for deleteCharactersCharacterIdFittingsFittingId. Equivalent to DeleteCharactersCharacterIdFittingsFittingId::meta(). */
    public static function deleteCharactersCharacterIdFittingsFittingIdMeta(): OperationMeta
    {
        return DeleteCharactersCharacterIdFittingsFittingId::meta();
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdFittingsGetItem>>
     * @scope esi-fittings.read_fittings.v1
     */
    public function getCharactersCharacterIdFittings(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/fittings', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdFittingsGetItem::from($item),
            (array) $response->data,
        ), GetCharactersCharacterIdFittings::meta());
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fittings.write_fittings.v1
     */
    public function postCharactersCharacterIdFittings(mixed $requestBody, int $characterId): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/fittings', ['character_id' => $characterId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, null, PostCharactersCharacterIdFittings::meta());
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fittings.write_fittings.v1
     */
    public function deleteCharactersCharacterIdFittingsFittingId(int $characterId, int $fittingId): EsiResult
    {
        $response = $this->transport->invoke('delete', '/characters/{character_id}/fittings/{fitting_id}', ['character_id' => $characterId, 'fitting_id' => $fittingId], [], []);
        return EsiResult::fromRaw($response, null, DeleteCharactersCharacterIdFittingsFittingId::meta());
    }
}
