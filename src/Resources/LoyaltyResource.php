<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Loyalty\GetCharactersCharacterIdLoyaltyPoints;
use Seatplus\EsiSchema\Resources\Loyalty\GetLoyaltyStoresCorporationIdOffers;

/**
 * ESI Loyalty resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class LoyaltyResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     * @scope esi-characters.read_loyalty.v1
     */
    public function getCharactersCharacterIdLoyaltyPoints(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdLoyaltyPoints::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     */
    public function getLoyaltyStoresCorporationIdOffers(int $corporationId): EsiResult
    {
        return GetLoyaltyStoresCorporationIdOffers::execute($this->transport, $corporationId);
    }
}
