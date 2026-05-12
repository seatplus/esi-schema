<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdLoyaltyPointsGetItem;
use Seatplus\EsiSchema\Responses\LoyaltyStoresCorporationIdOffersGetItem;

/**
 * ESI tag: Loyalty
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class LoyaltyResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCharactersCharacterIdLoyaltyPoints' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-wallet', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-characters.read_loyalty.v1'],
        'getLoyaltyStoresCorporationIdOffers' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
    ];

    /**
     * @return EsiResult<array<CharactersCharacterIdLoyaltyPointsGetItem>>
     * @scope esi-characters.read_loyalty.v1
     */
    public function getCharactersCharacterIdLoyaltyPoints(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/loyalty/points', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdLoyaltyPointsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdLoyaltyPoints'] ?? null);
    }

    /**
     * @return EsiResult<array<LoyaltyStoresCorporationIdOffersGetItem>>
     */
    public function getLoyaltyStoresCorporationIdOffers(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/loyalty/stores/{corporation_id}/offers', ['corporation_id' => $corporationId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => LoyaltyStoresCorporationIdOffersGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getLoyaltyStoresCorporationIdOffers'] ?? null);
    }
}
