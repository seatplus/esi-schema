<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Character;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdRolesGet;

/**
 * ESI operation: getCharactersCharacterIdRoles
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdRoles implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'char-detail', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-characters.read_corporation_roles.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CharactersCharacterIdRolesGet
     * @scope esi-characters.read_corporation_roles.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId): CharactersCharacterIdRolesGet
    {
        $response = $transport->invoke('get', '/characters/{character_id}/roles', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdRolesGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
