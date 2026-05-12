<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAssetsGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAssetsLocationsPostItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAssetsNamesPostItem;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdAssetsGetItem;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdAssetsLocationsPostItem;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdAssetsNamesPostItem;

/**
 * ESI tag: Assets
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class AssetsResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCharactersCharacterIdAssets' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-asset', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'postCharactersCharacterIdAssetsLocations' => ['cacheAge' => null, 'rateLimit' => ['group' => 'char-asset', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'postCharactersCharacterIdAssetsNames' => ['cacheAge' => null, 'rateLimit' => ['group' => 'char-asset', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getCorporationsCorporationIdAssets' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'corp-asset', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => ['Director'], 'cursor' => false],
        'postCorporationsCorporationIdAssetsLocations' => ['cacheAge' => null, 'rateLimit' => ['group' => 'corp-asset', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => ['Director'], 'cursor' => false],
        'postCorporationsCorporationIdAssetsNames' => ['cacheAge' => null, 'rateLimit' => ['group' => 'corp-asset', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => ['Director'], 'cursor' => false],
    ];

    /**
     * @return EsiResult<array<CharactersCharacterIdAssetsGetItem>>
     * @scope esi-assets.read_assets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdAssets(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/assets', ['character_id' => $characterId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdAssetsGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdAssetsLocationsPostItem>>
     * @scope esi-assets.read_assets.v1
     */
    public function postCharactersCharacterIdAssetsLocations(mixed $requestBody, int $characterId): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/assets/locations', ['character_id' => $characterId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdAssetsLocationsPostItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdAssetsNamesPostItem>>
     * @scope esi-assets.read_assets.v1
     */
    public function postCharactersCharacterIdAssetsNames(mixed $requestBody, int $characterId): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/assets/names', ['character_id' => $characterId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdAssetsNamesPostItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdAssetsGetItem>>
     * @scope esi-assets.read_corporation_assets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdAssets(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/assets', ['corporation_id' => $corporationId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdAssetsGetItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdAssetsLocationsPostItem>>
     * @scope esi-assets.read_corporation_assets.v1
     */
    public function postCorporationsCorporationIdAssetsLocations(mixed $requestBody, int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('post', '/corporations/{corporation_id}/assets/locations', ['corporation_id' => $corporationId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdAssetsLocationsPostItem::from($item),
            (array) $response->data,
        ));
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdAssetsNamesPostItem>>
     * @scope esi-assets.read_corporation_assets.v1
     */
    public function postCorporationsCorporationIdAssetsNames(mixed $requestBody, int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('post', '/corporations/{corporation_id}/assets/names', ['corporation_id' => $corporationId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdAssetsNamesPostItem::from($item),
            (array) $response->data,
        ));
    }
}
