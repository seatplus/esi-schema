<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Responses\MetaChangelog;
use Seatplus\EsiSchema\Responses\MetaCompatibilityDates;
use Seatplus\EsiSchema\Responses\MetaStatus;

/**
 * ESI tag: Meta
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class MetaResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getMetaChangelog' => ['cacheAge' => 0, 'rateLimit' => ['group' => 'meta', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getMetaCompatibilityDates' => ['cacheAge' => 0, 'rateLimit' => ['group' => 'meta', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
        'getMetaStatus' => ['cacheAge' => 0, 'rateLimit' => ['group' => 'meta', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
    ];

    /**
     * @return MetaChangelog
     */
    public function getMetaChangelog(): MetaChangelog
    {
        $response = $this->transport->invoke('get', '/meta/changelog', [], []);
        $dto = MetaChangelog::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return MetaCompatibilityDates
     */
    public function getMetaCompatibilityDates(): MetaCompatibilityDates
    {
        $response = $this->transport->invoke('get', '/meta/compatibility-dates', [], []);
        $dto = MetaCompatibilityDates::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return MetaStatus
     */
    public function getMetaStatus(): MetaStatus
    {
        $response = $this->transport->invoke('get', '/meta/status', [], []);
        $dto = MetaStatus::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }
}
