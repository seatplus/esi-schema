<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Wallet;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdWalletsDivisionTransactionsGetItem;

/**
 * ESI operation: getCorporationsCorporationIdWalletsDivisionTransactions
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdWalletsDivisionTransactions implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'corp-wallet', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => ['Accountant', 'Junior_Accountant'], 'cursor' => false, 'requiredScope' => 'esi-wallet.read_corporation_wallets.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdWalletsDivisionTransactionsGetItem>>
     * @scope esi-wallet.read_corporation_wallets.v1
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, int $division, ?int $fromId = null): EsiResult
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/wallets/{division}/transactions', ['corporation_id' => $corporationId, 'division' => $division], ['from_id' => $fromId]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdWalletsDivisionTransactionsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
