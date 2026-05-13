<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\MetaChangelog;
use Seatplus\EsiSchema\Operations\Meta\GetMetaChangelog;
use Seatplus\EsiSchema\Responses\MetaCompatibilityDates;
use Seatplus\EsiSchema\Operations\Meta\GetMetaCompatibilityDates;
use Seatplus\EsiSchema\Responses\MetaStatus;
use Seatplus\EsiSchema\Operations\Meta\GetMetaStatus;

/**
 * ESI tag: Meta
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class MetaResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getMetaChangelog' => GetMetaChangelog::meta(),
            'getMetaCompatibilityDates' => GetMetaCompatibilityDates::meta(),
            'getMetaStatus' => GetMetaStatus::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getMetaChangelog. Equivalent to GetMetaChangelog::meta(). */
    public static function getMetaChangelogMeta(): OperationMeta
    {
        return GetMetaChangelog::meta();
    }

    /** Pre-call metadata for getMetaCompatibilityDates. Equivalent to GetMetaCompatibilityDates::meta(). */
    public static function getMetaCompatibilityDatesMeta(): OperationMeta
    {
        return GetMetaCompatibilityDates::meta();
    }

    /** Pre-call metadata for getMetaStatus. Equivalent to GetMetaStatus::meta(). */
    public static function getMetaStatusMeta(): OperationMeta
    {
        return GetMetaStatus::meta();
    }

    /**
     * @return MetaChangelog
     */
    public function getMetaChangelog(): MetaChangelog
    {
        $response = $this->transport->invoke('get', '/meta/changelog', [], []);
        $dto = MetaChangelog::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetMetaChangelog::meta();
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
        $dto->operationMeta = GetMetaCompatibilityDates::meta();
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
        $dto->operationMeta = GetMetaStatus::meta();
        return $dto;
    }
}
