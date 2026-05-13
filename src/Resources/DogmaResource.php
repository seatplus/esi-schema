<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Operations\Dogma\GetDogmaAttributes;
use Seatplus\EsiSchema\Responses\DogmaAttributesAttributeIdGet;
use Seatplus\EsiSchema\Operations\Dogma\GetDogmaAttributesAttributeId;
use Seatplus\EsiSchema\Responses\DogmaDynamicItemsTypeIdItemIdGet;
use Seatplus\EsiSchema\Operations\Dogma\GetDogmaDynamicItemsTypeIdItemId;
use Seatplus\EsiSchema\Operations\Dogma\GetDogmaEffects;
use Seatplus\EsiSchema\Responses\DogmaEffectsEffectIdGet;
use Seatplus\EsiSchema\Operations\Dogma\GetDogmaEffectsEffectId;

/**
 * ESI tag: Dogma
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class DogmaResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getDogmaAttributes' => GetDogmaAttributes::meta(),
            'getDogmaAttributesAttributeId' => GetDogmaAttributesAttributeId::meta(),
            'getDogmaDynamicItemsTypeIdItemId' => GetDogmaDynamicItemsTypeIdItemId::meta(),
            'getDogmaEffects' => GetDogmaEffects::meta(),
            'getDogmaEffectsEffectId' => GetDogmaEffectsEffectId::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getDogmaAttributes. Equivalent to GetDogmaAttributes::meta(). */
    public static function getDogmaAttributesMeta(): OperationMeta
    {
        return GetDogmaAttributes::meta();
    }

    /** Pre-call metadata for getDogmaAttributesAttributeId. Equivalent to GetDogmaAttributesAttributeId::meta(). */
    public static function getDogmaAttributesAttributeIdMeta(): OperationMeta
    {
        return GetDogmaAttributesAttributeId::meta();
    }

    /** Pre-call metadata for getDogmaDynamicItemsTypeIdItemId. Equivalent to GetDogmaDynamicItemsTypeIdItemId::meta(). */
    public static function getDogmaDynamicItemsTypeIdItemIdMeta(): OperationMeta
    {
        return GetDogmaDynamicItemsTypeIdItemId::meta();
    }

    /** Pre-call metadata for getDogmaEffects. Equivalent to GetDogmaEffects::meta(). */
    public static function getDogmaEffectsMeta(): OperationMeta
    {
        return GetDogmaEffects::meta();
    }

    /** Pre-call metadata for getDogmaEffectsEffectId. Equivalent to GetDogmaEffectsEffectId::meta(). */
    public static function getDogmaEffectsEffectIdMeta(): OperationMeta
    {
        return GetDogmaEffectsEffectId::meta();
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getDogmaAttributes(): EsiResult
    {
        $response = $this->transport->invoke('get', '/dogma/attributes', [], []);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetDogmaAttributes::meta(),
        );
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
        $dto->operationMeta = GetDogmaAttributesAttributeId::meta();
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
        $dto->operationMeta = GetDogmaDynamicItemsTypeIdItemId::meta();
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
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetDogmaEffects::meta(),
        );
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
        $dto->operationMeta = GetDogmaEffectsEffectId::meta();
        return $dto;
    }
}
