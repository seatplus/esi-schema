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
    protected const array OPERATION_META = [
        'getAlliances' => ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
        'getAlliancesAllianceId' => ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
        'getAlliancesAllianceIdCorporations' => ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
        'getAlliancesAllianceIdIcons' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
    ];

    /**
     * @return EsiResult<array<int>>
     */
    public function getAlliances(): EsiResult
    {
        $response = $this->transport->invoke('get', '/alliances', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getAlliances'] ?? null);
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
        $dto->operationMeta = static::OPERATION_META['getAlliancesAllianceId'] ?? null;
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
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getAlliancesAllianceIdCorporations'] ?? null);
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
        $dto->operationMeta = static::OPERATION_META['getAlliancesAllianceIdIcons'] ?? null;
        return $dto;
    }
}
