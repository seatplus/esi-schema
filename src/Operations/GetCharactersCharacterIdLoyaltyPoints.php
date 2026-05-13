<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdLoyaltyPointsGetItem;

/**
 * ESI operation: getCharactersCharacterIdLoyaltyPoints
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdLoyaltyPoints implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-wallet', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-characters.read_loyalty.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdLoyaltyPointsGetItem>>
     * @scope esi-characters.read_loyalty.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId): EsiResult
    {
        $response = $transport->invoke('get', '/characters/{character_id}/loyalty/points', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdLoyaltyPointsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
