<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Sovereignty\GetSovereigntyCampaigns;
use Seatplus\EsiSchema\Resources\Sovereignty\GetSovereigntySystems;
use Seatplus\EsiSchema\Responses\SovereigntySystems;

/**
 * ESI Sovereignty resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
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
     * @return SovereigntySystems
     */
    public function getSovereigntySystems(): SovereigntySystems
    {
        return GetSovereigntySystems::execute($this->transport);
    }
}
