<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Skills;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAttributesGet;

/**
 * ESI operation: getCharactersCharacterIdAttributes
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdAttributes implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 120, 'rateLimit' => ['group' => 'char-detail', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-skills.read_skills.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CharactersCharacterIdAttributesGet
     * @scope esi-skills.read_skills.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId): CharactersCharacterIdAttributesGet
    {
        $response = $transport->invoke('get', '/characters/{character_id}/attributes', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdAttributesGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
