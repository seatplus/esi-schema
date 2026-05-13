<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Assets\GetCharactersCharacterIdAssets;
use Seatplus\EsiSchema\Resources\Assets\PostCharactersCharacterIdAssetsLocations;
use Seatplus\EsiSchema\Resources\Assets\PostCharactersCharacterIdAssetsNames;
use Seatplus\EsiSchema\Resources\Assets\GetCorporationsCorporationIdAssets;
use Seatplus\EsiSchema\Resources\Assets\PostCorporationsCorporationIdAssetsLocations;
use Seatplus\EsiSchema\Resources\Assets\PostCorporationsCorporationIdAssetsNames;

/**
 * ESI Assets resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class AssetsResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     * @scope esi-assets.read_assets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdAssets(int $characterId, int $page = 1): EsiResult
    {
        return GetCharactersCharacterIdAssets::execute($this->transport, $characterId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-assets.read_assets.v1
     */
    public function postCharactersCharacterIdAssetsLocations(mixed $requestBody, int $characterId): EsiResult
    {
        return PostCharactersCharacterIdAssetsLocations::execute($this->transport, $requestBody, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-assets.read_assets.v1
     */
    public function postCharactersCharacterIdAssetsNames(mixed $requestBody, int $characterId): EsiResult
    {
        return PostCharactersCharacterIdAssetsNames::execute($this->transport, $requestBody, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-assets.read_corporation_assets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdAssets(int $corporationId, int $page = 1): EsiResult
    {
        return GetCorporationsCorporationIdAssets::execute($this->transport, $corporationId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-assets.read_corporation_assets.v1
     */
    public function postCorporationsCorporationIdAssetsLocations(mixed $requestBody, int $corporationId): EsiResult
    {
        return PostCorporationsCorporationIdAssetsLocations::execute($this->transport, $requestBody, $corporationId);
    }

    /**
     * @return EsiResult
     * @scope esi-assets.read_corporation_assets.v1
     */
    public function postCorporationsCorporationIdAssetsNames(mixed $requestBody, int $corporationId): EsiResult
    {
        return PostCorporationsCorporationIdAssetsNames::execute($this->transport, $requestBody, $corporationId);
    }
}
