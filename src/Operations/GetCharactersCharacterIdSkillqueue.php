<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;

/**
 * ESI operation: getCharactersCharacterIdSkillqueue
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdSkillqueue implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 60, 'rateLimit' => ['group' => 'char-detail', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-skills.read_skillqueue.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-skills.read_skillqueue.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId): EsiResult
    {
        $response = $transport->invoke('get', '/characters/{character_id}/skillqueue', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, null, self::META);
    }
}
