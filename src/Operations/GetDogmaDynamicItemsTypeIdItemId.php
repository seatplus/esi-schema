<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\DogmaDynamicItemsTypeIdItemIdGet;

/**
 * ESI operation: getDogmaDynamicItemsTypeIdItemId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetDogmaDynamicItemsTypeIdItemId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return DogmaDynamicItemsTypeIdItemIdGet
     */
    public static function execute(EsiTransportInterface $transport, int $itemId, int $typeId): DogmaDynamicItemsTypeIdItemIdGet
    {
        $response = $transport->invoke('get', '/dogma/dynamic/items/{type_id}/{item_id}', ['item_id' => $itemId, 'type_id' => $typeId], []);
        $dto = DogmaDynamicItemsTypeIdItemIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
