<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\DogmaAttributesAttributeIdGet;

/**
 * ESI operation: getDogmaAttributesAttributeId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetDogmaAttributesAttributeId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return DogmaAttributesAttributeIdGet
     */
    public static function execute(EsiTransportInterface $transport, int $attributeId): DogmaAttributesAttributeIdGet
    {
        $response = $transport->invoke('get', '/dogma/attributes/{attribute_id}', ['attribute_id' => $attributeId], []);
        $dto = DogmaAttributesAttributeIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
