<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAssetsGetItem;
use Seatplus\EsiSchema\Operations\Assets\GetCharactersCharacterIdAssets;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAssetsLocationsPostItem;
use Seatplus\EsiSchema\Operations\Assets\PostCharactersCharacterIdAssetsLocations;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAssetsNamesPostItem;
use Seatplus\EsiSchema\Operations\Assets\PostCharactersCharacterIdAssetsNames;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdAssetsGetItem;
use Seatplus\EsiSchema\Operations\Assets\GetCorporationsCorporationIdAssets;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdAssetsLocationsPostItem;
use Seatplus\EsiSchema\Operations\Assets\PostCorporationsCorporationIdAssetsLocations;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdAssetsNamesPostItem;
use Seatplus\EsiSchema\Operations\Assets\PostCorporationsCorporationIdAssetsNames;

/**
 * ESI tag: Assets
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class AssetsResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdAssets' => GetCharactersCharacterIdAssets::meta(),
            'postCharactersCharacterIdAssetsLocations' => PostCharactersCharacterIdAssetsLocations::meta(),
            'postCharactersCharacterIdAssetsNames' => PostCharactersCharacterIdAssetsNames::meta(),
            'getCorporationsCorporationIdAssets' => GetCorporationsCorporationIdAssets::meta(),
            'postCorporationsCorporationIdAssetsLocations' => PostCorporationsCorporationIdAssetsLocations::meta(),
            'postCorporationsCorporationIdAssetsNames' => PostCorporationsCorporationIdAssetsNames::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdAssets. Equivalent to GetCharactersCharacterIdAssets::meta(). */
    public static function getCharactersCharacterIdAssetsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdAssets::meta();
    }

    /** Pre-call metadata for postCharactersCharacterIdAssetsLocations. Equivalent to PostCharactersCharacterIdAssetsLocations::meta(). */
    public static function postCharactersCharacterIdAssetsLocationsMeta(): OperationMeta
    {
        return PostCharactersCharacterIdAssetsLocations::meta();
    }

    /** Pre-call metadata for postCharactersCharacterIdAssetsNames. Equivalent to PostCharactersCharacterIdAssetsNames::meta(). */
    public static function postCharactersCharacterIdAssetsNamesMeta(): OperationMeta
    {
        return PostCharactersCharacterIdAssetsNames::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdAssets. Equivalent to GetCorporationsCorporationIdAssets::meta(). */
    public static function getCorporationsCorporationIdAssetsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdAssets::meta();
    }

    /** Pre-call metadata for postCorporationsCorporationIdAssetsLocations. Equivalent to PostCorporationsCorporationIdAssetsLocations::meta(). */
    public static function postCorporationsCorporationIdAssetsLocationsMeta(): OperationMeta
    {
        return PostCorporationsCorporationIdAssetsLocations::meta();
    }

    /** Pre-call metadata for postCorporationsCorporationIdAssetsNames. Equivalent to PostCorporationsCorporationIdAssetsNames::meta(). */
    public static function postCorporationsCorporationIdAssetsNamesMeta(): OperationMeta
    {
        return PostCorporationsCorporationIdAssetsNames::meta();
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdAssetsGetItem>>
     * @scope esi-assets.read_assets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdAssets(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/assets', ['character_id' => $characterId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdAssetsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdAssets::meta(),
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdAssetsLocationsPostItem>>
     * @scope esi-assets.read_assets.v1
     */
    public function postCharactersCharacterIdAssetsLocations(mixed $requestBody, int $characterId): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/assets/locations', ['character_id' => $characterId], [], (array) $requestBody);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdAssetsLocationsPostItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostCharactersCharacterIdAssetsLocations::meta(),
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdAssetsNamesPostItem>>
     * @scope esi-assets.read_assets.v1
     */
    public function postCharactersCharacterIdAssetsNames(mixed $requestBody, int $characterId): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/assets/names', ['character_id' => $characterId], [], (array) $requestBody);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdAssetsNamesPostItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostCharactersCharacterIdAssetsNames::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdAssetsGetItem>>
     * @scope esi-assets.read_corporation_assets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdAssets(int $corporationId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/assets', ['corporation_id' => $corporationId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdAssetsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCorporationsCorporationIdAssets::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdAssetsLocationsPostItem>>
     * @scope esi-assets.read_corporation_assets.v1
     */
    public function postCorporationsCorporationIdAssetsLocations(mixed $requestBody, int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('post', '/corporations/{corporation_id}/assets/locations', ['corporation_id' => $corporationId], [], (array) $requestBody);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdAssetsLocationsPostItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostCorporationsCorporationIdAssetsLocations::meta(),
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdAssetsNamesPostItem>>
     * @scope esi-assets.read_corporation_assets.v1
     */
    public function postCorporationsCorporationIdAssetsNames(mixed $requestBody, int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('post', '/corporations/{corporation_id}/assets/names', ['corporation_id' => $corporationId], [], (array) $requestBody);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdAssetsNamesPostItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostCorporationsCorporationIdAssetsNames::meta(),
        );
    }
}
