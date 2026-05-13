<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Dogma;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\DogmaEffectsEffectIdGet;

/**
 * ESI operation: getDogmaEffectsEffectId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetDogmaEffectsEffectId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return DogmaEffectsEffectIdGet
     */
    public static function execute(EsiTransportInterface $transport, int $effectId): DogmaEffectsEffectIdGet
    {
        $response = $transport->invoke('get', '/dogma/effects/{effect_id}', ['effect_id' => $effectId], []);
        $dto = DogmaEffectsEffectIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
