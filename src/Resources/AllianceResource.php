<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Operations\Alliance\GetAlliances;
use Seatplus\EsiSchema\Responses\AllianceDetail;
use Seatplus\EsiSchema\Operations\Alliance\GetAlliancesAllianceId;
use Seatplus\EsiSchema\Operations\Alliance\GetAlliancesAllianceIdCorporations;
use Seatplus\EsiSchema\Responses\AlliancesAllianceIdIconsGet;
use Seatplus\EsiSchema\Operations\Alliance\GetAlliancesAllianceIdIcons;

/**
 * ESI tag: Alliance
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class AllianceResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getAlliances' => GetAlliances::meta(),
            'getAlliancesAllianceId' => GetAlliancesAllianceId::meta(),
            'getAlliancesAllianceIdCorporations' => GetAlliancesAllianceIdCorporations::meta(),
            'getAlliancesAllianceIdIcons' => GetAlliancesAllianceIdIcons::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getAlliances. Equivalent to GetAlliances::meta(). */
    public static function getAlliancesMeta(): OperationMeta
    {
        return GetAlliances::meta();
    }

    /** Pre-call metadata for getAlliancesAllianceId. Equivalent to GetAlliancesAllianceId::meta(). */
    public static function getAlliancesAllianceIdMeta(): OperationMeta
    {
        return GetAlliancesAllianceId::meta();
    }

    /** Pre-call metadata for getAlliancesAllianceIdCorporations. Equivalent to GetAlliancesAllianceIdCorporations::meta(). */
    public static function getAlliancesAllianceIdCorporationsMeta(): OperationMeta
    {
        return GetAlliancesAllianceIdCorporations::meta();
    }

    /** Pre-call metadata for getAlliancesAllianceIdIcons. Equivalent to GetAlliancesAllianceIdIcons::meta(). */
    public static function getAlliancesAllianceIdIconsMeta(): OperationMeta
    {
        return GetAlliancesAllianceIdIcons::meta();
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getAlliances(): EsiResult
    {
        $response = $this->transport->invoke('get', '/alliances', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetAlliances::meta(),
        );
    }

    /**
     * @return AllianceDetail
     */
    public function getAlliancesAllianceId(int $allianceId): AllianceDetail
    {
        $response = $this->transport->invoke('get', '/alliances/{alliance_id}', ['alliance_id' => $allianceId], []);
        $dto = AllianceDetail::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetAlliancesAllianceId::meta();
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getAlliancesAllianceIdCorporations(int $allianceId): EsiResult
    {
        $response = $this->transport->invoke('get', '/alliances/{alliance_id}/corporations', ['alliance_id' => $allianceId], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetAlliancesAllianceIdCorporations::meta(),
        );
    }

    /**
     * @return AlliancesAllianceIdIconsGet
     */
    public function getAlliancesAllianceIdIcons(int $allianceId): AlliancesAllianceIdIconsGet
    {
        $response = $this->transport->invoke('get', '/alliances/{alliance_id}/icons', ['alliance_id' => $allianceId], []);
        $dto = AlliancesAllianceIdIconsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetAlliancesAllianceIdIcons::meta();
        return $dto;
    }
}
