<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\MarketsStructuresStructureIdGetItem;

/**
 * ESI operation: getMarketsStructuresStructureId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetMarketsStructuresStructureId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 300, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-markets.structure_markets.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<MarketsStructuresStructureIdGetItem>>
     * @scope esi-markets.structure_markets.v1
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $structureId, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/markets/structures/{structure_id}', ['structure_id' => $structureId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => MarketsStructuresStructureIdGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
