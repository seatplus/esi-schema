<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdWalletTransactionsGetItem;

/**
 * ESI operation: getCharactersCharacterIdWalletTransactions
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdWalletTransactions implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-wallet', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-wallet.read_character_wallet.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdWalletTransactionsGetItem>>
     * @scope esi-wallet.read_character_wallet.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, ?int $fromId = null): EsiResult
    {
        $response = $transport->invoke('get', '/characters/{character_id}/wallet/transactions', ['character_id' => $characterId], ['from_id' => $fromId]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdWalletTransactionsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
