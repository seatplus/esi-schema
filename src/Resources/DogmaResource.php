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
    /**
     * @return EsiResult<array<int>>
     */
    public function getDogmaAttributes(): EsiResult
    {
        $response = $this->transport->invoke('get', '/dogma/attributes', [], 'latest', []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return DogmaAttributesAttributeIdGet
     */
    public function getDogmaAttributesAttributeId(int $attributeId): DogmaAttributesAttributeIdGet
    {
        $response = $this->transport->invoke('get', '/dogma/attributes/{attribute_id}', ['attribute_id' => $attributeId], 'latest', []);
        $dto = DogmaAttributesAttributeIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return DogmaDynamicItemsTypeIdItemIdGet
     */
    public function getDogmaDynamicItemsTypeIdItemId(int $itemId, int $typeId): DogmaDynamicItemsTypeIdItemIdGet
    {
        $response = $this->transport->invoke('get', '/dogma/dynamic/items/{type_id}/{item_id}', ['item_id' => $itemId, 'type_id' => $typeId], 'latest', []);
        $dto = DogmaDynamicItemsTypeIdItemIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getDogmaEffects(): EsiResult
    {
        $response = $this->transport->invoke('get', '/dogma/effects', [], 'latest', []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return DogmaEffectsEffectIdGet
     */
    public function getDogmaEffectsEffectId(int $effectId): DogmaEffectsEffectIdGet
    {
        $response = $this->transport->invoke('get', '/dogma/effects/{effect_id}', ['effect_id' => $effectId], 'latest', []);
        $dto = DogmaEffectsEffectIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }
}
