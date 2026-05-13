<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Operations\Wallet\GetCharactersCharacterIdWallet;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdWalletJournalGetItem;
use Seatplus\EsiSchema\Operations\Wallet\GetCharactersCharacterIdWalletJournal;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdWalletTransactionsGetItem;
use Seatplus\EsiSchema\Operations\Wallet\GetCharactersCharacterIdWalletTransactions;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdWalletsGetItem;
use Seatplus\EsiSchema\Operations\Wallet\GetCorporationsCorporationIdWallets;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdWalletsDivisionJournalGetItem;
use Seatplus\EsiSchema\Operations\Wallet\GetCorporationsCorporationIdWalletsDivisionJournal;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdWalletsDivisionTransactionsGetItem;
use Seatplus\EsiSchema\Operations\Wallet\GetCorporationsCorporationIdWalletsDivisionTransactions;

/**
 * ESI tag: Wallet
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class WalletResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdWallet' => GetCharactersCharacterIdWallet::meta(),
            'getCharactersCharacterIdWalletJournal' => GetCharactersCharacterIdWalletJournal::meta(),
            'getCharactersCharacterIdWalletTransactions' => GetCharactersCharacterIdWalletTransactions::meta(),
            'getCorporationsCorporationIdWallets' => GetCorporationsCorporationIdWallets::meta(),
            'getCorporationsCorporationIdWalletsDivisionJournal' => GetCorporationsCorporationIdWalletsDivisionJournal::meta(),
            'getCorporationsCorporationIdWalletsDivisionTransactions' => GetCorporationsCorporationIdWalletsDivisionTransactions::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdWallet. Equivalent to GetCharactersCharacterIdWallet::meta(). */
    public static function getCharactersCharacterIdWalletMeta(): OperationMeta
    {
        return GetCharactersCharacterIdWallet::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdWalletJournal. Equivalent to GetCharactersCharacterIdWalletJournal::meta(). */
    public static function getCharactersCharacterIdWalletJournalMeta(): OperationMeta
    {
        return GetCharactersCharacterIdWalletJournal::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdWalletTransactions. Equivalent to GetCharactersCharacterIdWalletTransactions::meta(). */
    public static function getCharactersCharacterIdWalletTransactionsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdWalletTransactions::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdWallets. Equivalent to GetCorporationsCorporationIdWallets::meta(). */
    public static function getCorporationsCorporationIdWalletsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdWallets::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdWalletsDivisionJournal. Equivalent to GetCorporationsCorporationIdWalletsDivisionJournal::meta(). */
    public static function getCorporationsCorporationIdWalletsDivisionJournalMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdWalletsDivisionJournal::meta();
    }

    /** Pre-call metadata for getCorporationsCorporationIdWalletsDivisionTransactions. Equivalent to GetCorporationsCorporationIdWalletsDivisionTransactions::meta(). */
    public static function getCorporationsCorporationIdWalletsDivisionTransactionsMeta(): OperationMeta
    {
        return GetCorporationsCorporationIdWalletsDivisionTransactions::meta();
    }

    /**
     * @return EsiResult<float>
     * @scope esi-wallet.read_character_wallet.v1
     */
    public function getCharactersCharacterIdWallet(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/wallet', ['character_id' => $characterId], []);
        /** @var float $scalar */
        $scalar = (float) $response->data;
        return new EsiResult(
            data: $scalar,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdWalletJournalGetItem>>
     * @scope esi-wallet.read_character_wallet.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdWalletJournal(int $characterId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/wallet/journal', ['character_id' => $characterId], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdWalletJournalGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdWalletTransactionsGetItem>>
     * @scope esi-wallet.read_character_wallet.v1
     */
    public function getCharactersCharacterIdWalletTransactions(int $characterId, ?int $fromId = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/wallet/transactions', ['character_id' => $characterId], ['from_id' => $fromId]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdWalletTransactionsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdWalletsGetItem>>
     * @scope esi-wallet.read_corporation_wallets.v1
     */
    public function getCorporationsCorporationIdWallets(int $corporationId): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/wallets', ['corporation_id' => $corporationId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdWalletsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdWalletsDivisionJournalGetItem>>
     * @scope esi-wallet.read_corporation_wallets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdWalletsDivisionJournal(int $corporationId, int $division, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/wallets/{division}/journal', ['corporation_id' => $corporationId, 'division' => $division], ['page' => $page]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdWalletsDivisionJournalGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdWalletsDivisionTransactionsGetItem>>
     * @scope esi-wallet.read_corporation_wallets.v1
     */
    public function getCorporationsCorporationIdWalletsDivisionTransactions(int $corporationId, int $division, ?int $fromId = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/wallets/{division}/transactions', ['corporation_id' => $corporationId, 'division' => $division], ['from_id' => $fromId]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CorporationsCorporationIdWalletsDivisionTransactionsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }
}
