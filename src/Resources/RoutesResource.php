<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Responses\Route;

/**
 * ESI tag: Routes
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class RoutesResource extends AbstractResource
{
    /**
     * @return Route
     */
    public function postRoute(mixed $requestBody, int $originSystemId, int $destinationSystemId): Route
    {
        $response = $this->transport->invoke('post', '/route/{origin_system_id}/{destination_system_id}', ['origin_system_id' => $originSystemId, 'destination_system_id' => $destinationSystemId], 'latest', [], (array) $requestBody);
        $dto = Route::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }
}
