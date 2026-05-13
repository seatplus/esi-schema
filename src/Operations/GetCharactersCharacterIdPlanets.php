<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdPlanetsGetItem;

/**
 * ESI operation: getCharactersCharacterIdPlanets
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdPlanets implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 600, 'rateLimit' => ['group' => 'char-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-planets.manage_planets.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdPlanetsGetItem>>
     * @scope esi-planets.manage_planets.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId): EsiResult
    {
        $response = $transport->invoke('get', '/characters/{character_id}/planets', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdPlanetsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
