<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Industry;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationCorporationIdMiningObserversObserverIdGetItem;

/**
 * ESI operation: getCorporationCorporationIdMiningObserversObserverId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationCorporationIdMiningObserversObserverId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'corp-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => ['Accountant'], 'cursor' => false, 'requiredScope' => 'esi-industry.read_corporation_mining.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationCorporationIdMiningObserversObserverIdGetItem>>
     * @scope esi-industry.read_corporation_mining.v1
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, int $observerId, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/corporation/{corporation_id}/mining/observers/{observer_id}', ['corporation_id' => $corporationId, 'observer_id' => $observerId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationCorporationIdMiningObserversObserverIdGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
