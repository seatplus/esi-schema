<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Clones;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdClonesGet;

/**
 * ESI operation: getCharactersCharacterIdClones
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdClones implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 120, 'rateLimit' => ['group' => 'char-location', 'max-tokens' => 1200, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-clones.read_clones.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CharactersCharacterIdClonesGet
     * @scope esi-clones.read_clones.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId): CharactersCharacterIdClonesGet
    {
        $response = $transport->invoke('get', '/characters/{character_id}/clones', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdClonesGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
