<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Universe;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\UniverseStructuresStructureIdGet;

/**
 * ESI operation: getUniverseStructuresStructureId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetUniverseStructuresStructureId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-universe.read_structures.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return UniverseStructuresStructureIdGet
     * @scope esi-universe.read_structures.v1
     */
    public static function execute(EsiTransportInterface $transport, int $structureId): UniverseStructuresStructureIdGet
    {
        $response = $transport->invoke('get', '/universe/structures/{structure_id}', ['structure_id' => $structureId], []);
        $dto = UniverseStructuresStructureIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
