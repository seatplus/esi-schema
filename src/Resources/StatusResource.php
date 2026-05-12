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
    /**
     * @return StatusGet
     */
    public function getStatus(): StatusGet
    {
        $response = $this->transport->invoke('get', '/status', [], []);
        $dto = StatusGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }
}
