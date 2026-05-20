<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Incursions\GetIncursions;

/**
 * ESI Incursions resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class IncursionsResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     */
    public function getIncursions(): EsiResult
    {
        return GetIncursions::execute($this->transport);
    }
}
