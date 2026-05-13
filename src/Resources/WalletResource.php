<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Wallet\GetCharactersCharacterIdWallet;
use Seatplus\EsiSchema\Resources\Wallet\GetCharactersCharacterIdWalletJournal;
use Seatplus\EsiSchema\Resources\Wallet\GetCharactersCharacterIdWalletTransactions;
use Seatplus\EsiSchema\Resources\Wallet\GetCorporationsCorporationIdWallets;
use Seatplus\EsiSchema\Resources\Wallet\GetCorporationsCorporationIdWalletsDivisionJournal;
use Seatplus\EsiSchema\Resources\Wallet\GetCorporationsCorporationIdWalletsDivisionTransactions;

/**
 * ESI Wallet resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class WalletResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     * @scope esi-wallet.read_character_wallet.v1
     */
    public function getCharactersCharacterIdWallet(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdWallet::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-wallet.read_character_wallet.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdWalletJournal(int $characterId, int $page = 1): EsiResult
    {
        return GetCharactersCharacterIdWalletJournal::execute($this->transport, $characterId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-wallet.read_character_wallet.v1
     */
    public function getCharactersCharacterIdWalletTransactions(int $characterId, ?int $fromId = null): EsiResult
    {
        return GetCharactersCharacterIdWalletTransactions::execute($this->transport, $characterId, $fromId);
    }

    /**
     * @return EsiResult
     * @scope esi-wallet.read_corporation_wallets.v1
     */
    public function getCorporationsCorporationIdWallets(int $corporationId): EsiResult
    {
        return GetCorporationsCorporationIdWallets::execute($this->transport, $corporationId);
    }

    /**
     * @return EsiResult
     * @scope esi-wallet.read_corporation_wallets.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdWalletsDivisionJournal(int $corporationId, int $division, int $page = 1): EsiResult
    {
        return GetCorporationsCorporationIdWalletsDivisionJournal::execute($this->transport, $corporationId, $division, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-wallet.read_corporation_wallets.v1
     */
    public function getCorporationsCorporationIdWalletsDivisionTransactions(int $corporationId, int $division, ?int $fromId = null): EsiResult
    {
        return GetCorporationsCorporationIdWalletsDivisionTransactions::execute($this->transport, $corporationId, $division, $fromId);
    }
}
