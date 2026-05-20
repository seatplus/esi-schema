<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Alliance\GetAlliances;
use Seatplus\EsiSchema\Resources\Alliance\GetAlliancesAllianceId;
use Seatplus\EsiSchema\Responses\AllianceDetail;
use Seatplus\EsiSchema\Resources\Alliance\GetAlliancesAllianceIdCorporations;
use Seatplus\EsiSchema\Resources\Alliance\GetAlliancesAllianceIdIcons;
use Seatplus\EsiSchema\Responses\AlliancesAllianceIdIconsGet;

/**
 * ESI Alliance resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class AllianceResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     */
    public function getAlliances(): EsiResult
    {
        return GetAlliances::execute($this->transport);
    }

    /**
     * @return AllianceDetail
     */
    public function getAlliancesAllianceId(int $allianceId): AllianceDetail
    {
        return GetAlliancesAllianceId::execute($this->transport, $allianceId);
    }

    /**
     * @return EsiResult
     */
    public function getAlliancesAllianceIdCorporations(int $allianceId): EsiResult
    {
        return GetAlliancesAllianceIdCorporations::execute($this->transport, $allianceId);
    }

    /**
     * @return AlliancesAllianceIdIconsGet
     */
    public function getAlliancesAllianceIdIcons(int $allianceId): AlliancesAllianceIdIconsGet
    {
        return GetAlliancesAllianceIdIcons::execute($this->transport, $allianceId);
    }
}
