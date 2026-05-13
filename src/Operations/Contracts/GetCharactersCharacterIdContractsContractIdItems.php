<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Contracts;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdContractsContractIdItemsGetItem;

/**
 * ESI operation: getCharactersCharacterIdContractsContractIdItems
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdContractsContractIdItems implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-contract', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-contracts.read_character_contracts.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdContractsContractIdItemsGetItem>>
     * @scope esi-contracts.read_character_contracts.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, int $contractId): EsiResult
    {
        $response = $transport->invoke('get', '/characters/{character_id}/contracts/{contract_id}/items', ['character_id' => $characterId, 'contract_id' => $contractId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdContractsContractIdItemsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
