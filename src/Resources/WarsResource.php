<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Wars\GetWars;
use Seatplus\EsiSchema\Resources\Wars\GetWarsWarId;
use Seatplus\EsiSchema\Responses\WarsWarIdGet;
use Seatplus\EsiSchema\Resources\Wars\GetWarsWarIdKillmails;

/**
 * ESI Wars resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class WarsResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     */
    public function getWars(?int $maxWarId = null): EsiResult
    {
        return GetWars::execute($this->transport, $maxWarId);
    }

    /**
     * @return WarsWarIdGet
     */
    public function getWarsWarId(int $warId): WarsWarIdGet
    {
        return GetWarsWarId::execute($this->transport, $warId);
    }

    /**
     * @return EsiResult
     * @paginated Use $page param to iterate pages.
     */
    public function getWarsWarIdKillmails(int $warId, int $page = 1): EsiResult
    {
        return GetWarsWarIdKillmails::execute($this->transport, $warId, $page);
    }
}
