<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Contracts;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\ContractsPublicBidsContractIdGetItem;

/**
 * ESI operation: getContractsPublicBidsContractId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetContractsPublicBidsContractId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 300, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<ContractsPublicBidsContractIdGetItem>>
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $contractId, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/contracts/public/bids/{contract_id}', ['contract_id' => $contractId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => ContractsPublicBidsContractIdGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
