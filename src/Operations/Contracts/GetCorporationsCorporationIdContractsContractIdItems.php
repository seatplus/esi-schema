<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Contracts;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdContractsContractIdItemsGetItem;

/**
 * ESI operation: getCorporationsCorporationIdContractsContractIdItems
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdContractsContractIdItems implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'corp-contract', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-contracts.read_corporation_contracts.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdContractsContractIdItemsGetItem>>
     * @scope esi-contracts.read_corporation_contracts.v1
     */
    public static function execute(EsiTransportInterface $transport, int $contractId, int $corporationId): EsiResult
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/contracts/{contract_id}/items', ['contract_id' => $contractId, 'corporation_id' => $corporationId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdContractsContractIdItemsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
