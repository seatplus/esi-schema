<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Routes;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\Route;

/**
 * ESI operation: postRoute
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class PostRoute implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 0, 'rateLimit' => ['group' => 'routes', 'max-tokens' => 3600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return Route
     */
    public static function execute(EsiTransportInterface $transport, mixed $requestBody, int $originSystemId, int $destinationSystemId): Route
    {
        $response = $transport->invoke('post', '/route/{origin_system_id}/{destination_system_id}', ['origin_system_id' => $originSystemId, 'destination_system_id' => $destinationSystemId], [], (array) $requestBody);
        $dto = Route::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
