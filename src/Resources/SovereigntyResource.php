<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Sovereignty\GetSovereigntyCampaigns;
use Seatplus\EsiSchema\Resources\Sovereignty\GetSovereigntyMap;
use Seatplus\EsiSchema\Resources\Sovereignty\GetSovereigntyStructures;

/**
 * ESI Sovereignty resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class SovereigntyResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     */
    public function getSovereigntyCampaigns(): EsiResult
    {
        return GetSovereigntyCampaigns::execute($this->transport);
    }

    /**
     * @return EsiResult
     */
    public function getSovereigntyMap(): EsiResult
    {
        return GetSovereigntyMap::execute($this->transport);
    }

    /**
     * @return EsiResult
     */
    public function getSovereigntyStructures(): EsiResult
    {
        return GetSovereigntyStructures::execute($this->transport);
    }
}
