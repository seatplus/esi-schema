<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Responses\CharactersCharacterIdLocationGet;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdOnlineGet;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdShipGet;

/**
 * ESI tag: Location
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class LocationResource extends AbstractResource
{
    /**
     * @return CharactersCharacterIdLocationGet
     * @scope esi-location.read_location.v1
     */
    public function getCharactersCharacterIdLocation(int $characterId): CharactersCharacterIdLocationGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/location', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdLocationGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return CharactersCharacterIdOnlineGet
     * @scope esi-location.read_online.v1
     */
    public function getCharactersCharacterIdOnline(int $characterId): CharactersCharacterIdOnlineGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/online', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdOnlineGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return CharactersCharacterIdShipGet
     * @scope esi-location.read_ship_type.v1
     */
    public function getCharactersCharacterIdShip(int $characterId): CharactersCharacterIdShipGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/ship', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdShipGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }
}
