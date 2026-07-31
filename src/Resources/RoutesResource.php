<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\Resources\Routes\PostRoute;
use Seatplus\EsiSchema\Responses\Route;

/**
 * ESI Routes resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class RoutesResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return Route
     */
    public function postRoute(mixed $requestBody, int $originSystemId, int $destinationSystemId): Route
    {
        return PostRoute::execute($this->transport, $requestBody, $originSystemId, $destinationSystemId);
    }
}
