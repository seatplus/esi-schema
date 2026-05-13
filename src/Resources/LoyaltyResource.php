<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdLoyaltyPointsGetItem;
use Seatplus\EsiSchema\Operations\Loyalty\GetCharactersCharacterIdLoyaltyPoints;
use Seatplus\EsiSchema\Responses\LoyaltyStoresCorporationIdOffersGetItem;
use Seatplus\EsiSchema\Operations\Loyalty\GetLoyaltyStoresCorporationIdOffers;

/**
 * ESI tag: Loyalty
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class LoyaltyResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdLoyaltyPoints' => GetCharactersCharacterIdLoyaltyPoints::meta(),
            'getLoyaltyStoresCorporationIdOffers' => GetLoyaltyStoresCorporationIdOffers::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdLoyaltyPoints. Equivalent to GetCharactersCharacterIdLoyaltyPoints::meta(). */
    public static function getCharactersCharacterIdLoyaltyPointsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdLoyaltyPoints::meta();
    }

    /** Pre-call metadata for getLoyaltyStoresCorporationIdOffers. Equivalent to GetLoyaltyStoresCorporationIdOffers::meta(). */
    public static function getLoyaltyStoresCorporationIdOffersMeta(): OperationMeta
    {
        return GetLoyaltyStoresCorporationIdOffers::meta();
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdLoyaltyPointsGetItem>>
     * @scope esi-characters.read_loyalty.v1
     */
    public function getCharactersCharacterIdLoyaltyPoints(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/loyalty/points', ['character_id' => $characterId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdLoyaltyPointsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdLoyaltyPoints::meta(),
        );
    }

    /**
     * @return EsiResult<array<LoyaltyStoresCorporationIdOffersGetItem>>
     */
    public function getLoyaltyStoresCorporationIdOffers(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/loyalty/stores/{corporation_id}/offers', ['corporation_id' => $corporationId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => LoyaltyStoresCorporationIdOffersGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetLoyaltyStoresCorporationIdOffers::meta(),
        );
    }
}
