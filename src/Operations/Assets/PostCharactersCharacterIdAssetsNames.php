<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Assets;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAssetsNamesPostItem;

/**
 * ESI operation: postCharactersCharacterIdAssetsNames
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class PostCharactersCharacterIdAssetsNames implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => ['group' => 'char-asset', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-assets.read_assets.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdAssetsNamesPostItem>>
     * @scope esi-assets.read_assets.v1
     */
    public static function execute(EsiTransportInterface $transport, mixed $requestBody, int $characterId): EsiResult
    {
        $response = $transport->invoke('post', '/characters/{character_id}/assets/names', ['character_id' => $characterId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdAssetsNamesPostItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
