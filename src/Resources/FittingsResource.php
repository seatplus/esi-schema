<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFittingsGetItem;

/**
 * ESI tag: Fittings
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class FittingsResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCharactersCharacterIdFittings' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'fitting', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'postCharactersCharacterIdFittings' => ['cacheAge' => null, 'rateLimit' => ['group' => 'fitting', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'deleteCharactersCharacterIdFittingsFittingId' => ['cacheAge' => null, 'rateLimit' => ['group' => 'fitting', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
    ];

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
        ), static::OPERATION_META['getCharactersCharacterIdFittings'] ?? null);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fittings.write_fittings.v1
     */
    public function postCharactersCharacterIdFittings(mixed $requestBody, int $characterId): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/fittings', ['character_id' => $characterId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, null, static::OPERATION_META['postCharactersCharacterIdFittings'] ?? null);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fittings.write_fittings.v1
     */
    public function deleteCharactersCharacterIdFittingsFittingId(int $characterId, int $fittingId): EsiResult
    {
        $response = $this->transport->invoke('delete', '/characters/{character_id}/fittings/{fitting_id}', ['character_id' => $characterId, 'fitting_id' => $fittingId], [], []);
        return EsiResult::fromRaw($response, null, static::OPERATION_META['deleteCharactersCharacterIdFittingsFittingId'] ?? null);
    }
}
