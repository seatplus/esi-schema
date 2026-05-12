<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdWalletJournalGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdWalletTransactionsGetItem;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdWalletsGetItem;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdWalletsDivisionJournalGetItem;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdWalletsDivisionTransactionsGetItem;

/**
 * ESI tag: Wallet
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class WalletResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCharactersCharacterIdWallet' => ['cacheAge' => 120, 'rateLimit' => ['group' => 'char-wallet', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-wallet.read_character_wallet.v1'],
        'getCharactersCharacterIdWalletJournal' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-wallet', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-wallet.read_character_wallet.v1'],
        'getCharactersCharacterIdWalletTransactions' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-wallet', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-wallet.read_character_wallet.v1'],
        'getCorporationsCorporationIdWallets' => ['cacheAge' => 300, 'rateLimit' => ['group' => 'corp-wallet', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => ['Accountant', 'Junior_Accountant'], 'cursor' => false, 'requiredScope' => 'esi-wallet.read_corporation_wallets.v1'],
        'getCorporationsCorporationIdWalletsDivisionJournal' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'corp-wallet', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => ['Accountant', 'Junior_Accountant'], 'cursor' => false, 'requiredScope' => 'esi-wallet.read_corporation_wallets.v1'],
        'getCorporationsCorporationIdWalletsDivisionTransactions' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'corp-wallet', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => ['Accountant', 'Junior_Accountant'], 'cursor' => false, 'requiredScope' => 'esi-wallet.read_corporation_wallets.v1'],
    ];

    /**
     * @return EsiResult<float>
     * @scope esi-wallet.read_character_wallet.v1
     */
    public function getCharactersCharacterIdWallet(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/wallet', ['character_id' => $characterId], []);
        /** @var float $scalar */
        $scalar = (float) $response->data;
        return EsiResult::fromRaw($response, $scalar, static::OPERATION_META['getCharactersCharacterIdWallet'] ?? null);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdWalletJournalGetItem>>
     * @scope esi-wallet.read_character_wallet.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdWalletJournal(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/wallet/journal', ['character_id' => $characterId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdWalletJournalGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdWalletJournal'] ?? null);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdWalletTransactionsGetItem>>
     * @scope esi-wallet.read_character_wallet.v1
     */
    public function getCharactersCharacterIdWalletTransactions(int $characterId, ?int $fromId = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/wallet/transactions', ['character_id' => $characterId], ['from_id' => $fromId]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdWalletTransactionsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdWalletTransactions'] ?? null);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdWalletsGetItem>>
     * @scope esi-wallet.read_corporation_wallets.v1
     */
    public function getCorporationsCorporationIdWallets(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/wallets', ['corporation_id' => $corporationId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdWalletsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCorporationsCorporationIdWallets'] ?? null);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdWalletsDivisionJournalGetItem>>
     * @scope esi-wallet.read_corporation_wallets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdWalletsDivisionJournal(int $corporationId, int $division, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/wallets/{division}/journal', ['corporation_id' => $corporationId, 'division' => $division], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdWalletsDivisionJournalGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCorporationsCorporationIdWalletsDivisionJournal'] ?? null);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdWalletsDivisionTransactionsGetItem>>
     * @scope esi-wallet.read_corporation_wallets.v1
     */
    public function getCorporationsCorporationIdWalletsDivisionTransactions(int $corporationId, int $division, ?int $fromId = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/wallets/{division}/transactions', ['corporation_id' => $corporationId, 'division' => $division], ['from_id' => $fromId]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdWalletsDivisionTransactionsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCorporationsCorporationIdWalletsDivisionTransactions'] ?? null);
    }
}
