<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Responses\StatusGet;

/**
 * ESI tag: Status
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class StatusResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getStatus' => ['cacheAge' => 30, 'rateLimit' => ['group' => 'status', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null],
    ];

    /**
     * @return StatusGet
     */
    public function getStatus(): StatusGet
    {
        $response = $this->transport->invoke('get', '/status', [], []);
        $dto = StatusGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getStatus'] ?? null;
        return $dto;
    }
}
