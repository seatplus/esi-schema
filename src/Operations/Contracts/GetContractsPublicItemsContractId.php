<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Contracts;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\ContractsPublicItemsContractIdGetItem;

/**
 * ESI operation: getContractsPublicItemsContractId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetContractsPublicItemsContractId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<ContractsPublicItemsContractIdGetItem>>
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $contractId, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/contracts/public/items/{contract_id}', ['contract_id' => $contractId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => ContractsPublicItemsContractIdGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
