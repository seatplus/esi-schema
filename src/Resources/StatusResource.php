<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\Resources\Status\GetStatus;
use Seatplus\EsiSchema\Responses\StatusGet;

/**
 * ESI Status resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class StatusResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return StatusGet
     */
    public function getStatus(): StatusGet
    {
        return GetStatus::execute($this->transport);
    }
}
