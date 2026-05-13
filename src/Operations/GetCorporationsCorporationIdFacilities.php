<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdFacilitiesGetItem;

/**
 * ESI operation: getCorporationsCorporationIdFacilities
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdFacilities implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => ['Factory_Manager'], 'cursor' => false, 'requiredScope' => 'esi-corporations.read_facilities.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdFacilitiesGetItem>>
     * @scope esi-corporations.read_facilities.v1
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId): EsiResult
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/facilities', ['corporation_id' => $corporationId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdFacilitiesGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
