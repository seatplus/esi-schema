<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\Route;
use Seatplus\EsiSchema\Operations\Routes\PostRoute;

/**
 * ESI tag: Routes
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class RoutesResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'postRoute' => PostRoute::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for postRoute. Equivalent to PostRoute::meta(). */
    public static function postRouteMeta(): OperationMeta
    {
        return PostRoute::meta();
    }

    /**
     * @return Route
     */
    public function postRoute(mixed $requestBody, int $originSystemId, int $destinationSystemId): Route
    {
        $response = $this->transport->invoke('post', '/route/{origin_system_id}/{destination_system_id}', ['origin_system_id' => $originSystemId, 'destination_system_id' => $destinationSystemId], [], (array) $requestBody);
        $dto = Route::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }
}
