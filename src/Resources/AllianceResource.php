<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\AllianceDetail;
use Seatplus\EsiSchema\Responses\AlliancesAllianceIdIconsGet;

/**
 * ESI tag: Alliance
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class AllianceResource extends AbstractResource
{
    /**
     * @return EsiResult<array<int>>
     */
    public function getAlliances(): EsiResult
    {
        $response = $this->transport->invoke('get', '/alliances', [], 'latest', []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return AllianceDetail
     */
    public function getAlliancesAllianceId(int $allianceId): AllianceDetail
    {
        $response = $this->transport->invoke('get', '/alliances/{alliance_id}', ['alliance_id' => $allianceId], 'latest', []);
        $dto = AllianceDetail::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getAlliancesAllianceIdCorporations(int $allianceId): EsiResult
    {
        $response = $this->transport->invoke('get', '/alliances/{alliance_id}/corporations', ['alliance_id' => $allianceId], 'latest', []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return AlliancesAllianceIdIconsGet
     */
    public function getAlliancesAllianceIdIcons(int $allianceId): AlliancesAllianceIdIconsGet
    {
        $response = $this->transport->invoke('get', '/alliances/{alliance_id}/icons', ['alliance_id' => $allianceId], 'latest', []);
        $dto = AlliancesAllianceIdIconsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }
}
