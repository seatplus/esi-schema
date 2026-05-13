<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdFittingsGetItem;

/**
 * ESI operation: getCharactersCharacterIdFittings
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdFittings implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 300, 'rateLimit' => ['group' => 'fitting', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-fittings.read_fittings.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdFittingsGetItem>>
     * @scope esi-fittings.read_fittings.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId): EsiResult
    {
        $response = $transport->invoke('get', '/characters/{character_id}/fittings', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdFittingsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
