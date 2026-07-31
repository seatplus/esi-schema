<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\Resources\Location\GetCharactersCharacterIdLocation;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdLocationGet;
use Seatplus\EsiSchema\Resources\Location\GetCharactersCharacterIdOnline;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdOnlineGet;
use Seatplus\EsiSchema\Resources\Location\GetCharactersCharacterIdShip;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdShipGet;

/**
 * ESI Location resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class LocationResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return CharactersCharacterIdLocationGet
     * @scope esi-location.read_location.v1
     */
    public function getCharactersCharacterIdLocation(int $characterId): CharactersCharacterIdLocationGet
    {
        return GetCharactersCharacterIdLocation::execute($this->transport, $characterId);
    }

    /**
     * @return CharactersCharacterIdOnlineGet
     * @scope esi-location.read_online.v1
     */
    public function getCharactersCharacterIdOnline(int $characterId): CharactersCharacterIdOnlineGet
    {
        return GetCharactersCharacterIdOnline::execute($this->transport, $characterId);
    }

    /**
     * @return CharactersCharacterIdShipGet
     * @scope esi-location.read_ship_type.v1
     */
    public function getCharactersCharacterIdShip(int $characterId): CharactersCharacterIdShipGet
    {
        return GetCharactersCharacterIdShip::execute($this->transport, $characterId);
    }
}
