<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\DogmaAttributesAttributeIdGet;
use Seatplus\EsiSchema\Responses\DogmaDynamicItemsTypeIdItemIdGet;
use Seatplus\EsiSchema\Responses\DogmaEffectsEffectIdGet;

/**
 * ESI tag: Dogma
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class DogmaResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getDogmaAttributes' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getDogmaAttributesAttributeId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getDogmaDynamicItemsTypeIdItemId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getDogmaEffects' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
        'getDogmaEffectsEffectId' => ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false],
    ];

    /**
     * @return EsiResult<array<int>>
     */
    public function getDogmaAttributes(): EsiResult
    {
        $response = $this->transport->invoke('get', '/dogma/attributes', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getDogmaAttributes'] ?? null);
    }

    /**
     * @return DogmaAttributesAttributeIdGet
     */
    public function getDogmaAttributesAttributeId(int $attributeId): DogmaAttributesAttributeIdGet
    {
        $response = $this->transport->invoke('get', '/dogma/attributes/{attribute_id}', ['attribute_id' => $attributeId], []);
        $dto = DogmaAttributesAttributeIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getDogmaAttributesAttributeId'] ?? null;
        return $dto;
    }

    /**
     * @return DogmaDynamicItemsTypeIdItemIdGet
     */
    public function getDogmaDynamicItemsTypeIdItemId(int $itemId, int $typeId): DogmaDynamicItemsTypeIdItemIdGet
    {
        $response = $this->transport->invoke('get', '/dogma/dynamic/items/{type_id}/{item_id}', ['item_id' => $itemId, 'type_id' => $typeId], []);
        $dto = DogmaDynamicItemsTypeIdItemIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getDogmaDynamicItemsTypeIdItemId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getDogmaEffects(): EsiResult
    {
        $response = $this->transport->invoke('get', '/dogma/effects', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data, static::OPERATION_META['getDogmaEffects'] ?? null);
    }

    /**
     * @return DogmaEffectsEffectIdGet
     */
    public function getDogmaEffectsEffectId(int $effectId): DogmaEffectsEffectIdGet
    {
        $response = $this->transport->invoke('get', '/dogma/effects/{effect_id}', ['effect_id' => $effectId], []);
        $dto = DogmaEffectsEffectIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getDogmaEffectsEffectId'] ?? null;
        return $dto;
    }
}
