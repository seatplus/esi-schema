<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Wallet;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdWalletsGetItem;

/**
 * ESI operation: getCorporationsCorporationIdWallets
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdWallets implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 300, 'rateLimit' => ['group' => 'corp-wallet', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => ['Accountant', 'Junior_Accountant'], 'cursor' => false, 'requiredScope' => 'esi-wallet.read_corporation_wallets.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdWalletsGetItem>>
     * @scope esi-wallet.read_corporation_wallets.v1
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId): EsiResult
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/wallets', ['corporation_id' => $corporationId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdWalletsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
