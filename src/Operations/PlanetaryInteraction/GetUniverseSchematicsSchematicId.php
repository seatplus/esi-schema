<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\PlanetaryInteraction;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\UniverseSchematicsSchematicIdGet;

/**
 * ESI operation: getUniverseSchematicsSchematicId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetUniverseSchematicsSchematicId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return UniverseSchematicsSchematicIdGet
     */
    public static function execute(EsiTransportInterface $transport, int $schematicId): UniverseSchematicsSchematicIdGet
    {
        $response = $transport->invoke('get', '/universe/schematics/{schematic_id}', ['schematic_id' => $schematicId], []);
        $dto = UniverseSchematicsSchematicIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
