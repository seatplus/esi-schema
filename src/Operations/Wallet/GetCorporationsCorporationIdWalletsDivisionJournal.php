<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Wallet;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdWalletsDivisionJournalGetItem;

/**
 * ESI operation: getCorporationsCorporationIdWalletsDivisionJournal
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdWalletsDivisionJournal implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'corp-wallet', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => ['Accountant', 'Junior_Accountant'], 'cursor' => false, 'requiredScope' => 'esi-wallet.read_corporation_wallets.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdWalletsDivisionJournalGetItem>>
     * @scope esi-wallet.read_corporation_wallets.v1
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, int $division, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/wallets/{division}/journal', ['corporation_id' => $corporationId, 'division' => $division], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdWalletsDivisionJournalGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
