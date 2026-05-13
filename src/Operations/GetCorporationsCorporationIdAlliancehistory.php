<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdAlliancehistoryGetItem;

/**
 * ESI operation: getCorporationsCorporationIdAlliancehistory
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdAlliancehistory implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdAlliancehistoryGetItem>>
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId): EsiResult
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/alliancehistory', ['corporation_id' => $corporationId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdAlliancehistoryGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
