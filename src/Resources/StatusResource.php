<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\StatusGet;
use Seatplus\EsiSchema\Operations\Status\GetStatus;

/**
 * ESI tag: Status
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class StatusResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getStatus' => GetStatus::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getStatus. Equivalent to GetStatus::meta(). */
    public static function getStatusMeta(): OperationMeta
    {
        return GetStatus::meta();
    }

    /**
     * @return StatusGet
     */
    public function getStatus(): StatusGet
    {
        $response = $this->transport->invoke('get', '/status', [], []);
        $dto = StatusGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetStatus::meta();
        return $dto;
    }
}
