<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Dogma\GetDogmaAttributes;
use Seatplus\EsiSchema\Resources\Dogma\GetDogmaAttributesAttributeId;
use Seatplus\EsiSchema\Responses\DogmaAttributesAttributeIdGet;
use Seatplus\EsiSchema\Resources\Dogma\GetDogmaDynamicItemsTypeIdItemId;
use Seatplus\EsiSchema\Responses\DogmaDynamicItemsTypeIdItemIdGet;
use Seatplus\EsiSchema\Resources\Dogma\GetDogmaEffects;
use Seatplus\EsiSchema\Resources\Dogma\GetDogmaEffectsEffectId;
use Seatplus\EsiSchema\Responses\DogmaEffectsEffectIdGet;

/**
 * ESI Dogma resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class DogmaResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     */
    public function getDogmaAttributes(): EsiResult
    {
        return GetDogmaAttributes::execute($this->transport);
    }

    /**
     * @return DogmaAttributesAttributeIdGet
     */
    public function getDogmaAttributesAttributeId(int $attributeId): DogmaAttributesAttributeIdGet
    {
        return GetDogmaAttributesAttributeId::execute($this->transport, $attributeId);
    }

    /**
     * @return DogmaDynamicItemsTypeIdItemIdGet
     */
    public function getDogmaDynamicItemsTypeIdItemId(int $itemId, int $typeId): DogmaDynamicItemsTypeIdItemIdGet
    {
        return GetDogmaDynamicItemsTypeIdItemId::execute($this->transport, $itemId, $typeId);
    }

    /**
     * @return EsiResult
     */
    public function getDogmaEffects(): EsiResult
    {
        return GetDogmaEffects::execute($this->transport);
    }

    /**
     * @return DogmaEffectsEffectIdGet
     */
    public function getDogmaEffectsEffectId(int $effectId): DogmaEffectsEffectIdGet
    {
        return GetDogmaEffectsEffectId::execute($this->transport, $effectId);
    }
}
