<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdLocationGet;
use Seatplus\EsiSchema\Operations\Location\GetCharactersCharacterIdLocation;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdOnlineGet;
use Seatplus\EsiSchema\Operations\Location\GetCharactersCharacterIdOnline;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdShipGet;
use Seatplus\EsiSchema\Operations\Location\GetCharactersCharacterIdShip;

/**
 * ESI tag: Location
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class LocationResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdLocation' => GetCharactersCharacterIdLocation::meta(),
            'getCharactersCharacterIdOnline' => GetCharactersCharacterIdOnline::meta(),
            'getCharactersCharacterIdShip' => GetCharactersCharacterIdShip::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdLocation. Equivalent to GetCharactersCharacterIdLocation::meta(). */
    public static function getCharactersCharacterIdLocationMeta(): OperationMeta
    {
        return GetCharactersCharacterIdLocation::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdOnline. Equivalent to GetCharactersCharacterIdOnline::meta(). */
    public static function getCharactersCharacterIdOnlineMeta(): OperationMeta
    {
        return GetCharactersCharacterIdOnline::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdShip. Equivalent to GetCharactersCharacterIdShip::meta(). */
    public static function getCharactersCharacterIdShipMeta(): OperationMeta
    {
        return GetCharactersCharacterIdShip::meta();
    }

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
        $dto->operationMeta = GetCharactersCharacterIdLocation::meta();
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
        $dto->operationMeta = GetCharactersCharacterIdOnline::meta();
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
        $dto->operationMeta = GetCharactersCharacterIdShip::meta();
        return $dto;
    }
}
