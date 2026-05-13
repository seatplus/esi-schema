<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\Resources\Meta\GetMetaChangelog;
use Seatplus\EsiSchema\Responses\MetaChangelog;
use Seatplus\EsiSchema\Resources\Meta\GetMetaCompatibilityDates;
use Seatplus\EsiSchema\Responses\MetaCompatibilityDates;
use Seatplus\EsiSchema\Resources\Meta\GetMetaStatus;
use Seatplus\EsiSchema\Responses\MetaStatus;

/**
 * ESI Meta resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class MetaResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return MetaChangelog
     */
    public function getMetaChangelog(): MetaChangelog
    {
        return GetMetaChangelog::execute($this->transport);
    }

    /**
     * @return MetaCompatibilityDates
     */
    public function getMetaCompatibilityDates(): MetaCompatibilityDates
    {
        return GetMetaCompatibilityDates::execute($this->transport);
    }

    /**
     * @return MetaStatus
     */
    public function getMetaStatus(): MetaStatus
    {
        return GetMetaStatus::execute($this->transport);
    }
}
