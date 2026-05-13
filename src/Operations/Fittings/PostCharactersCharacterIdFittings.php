<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Fittings;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;

/**
 * ESI operation: postCharactersCharacterIdFittings
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class PostCharactersCharacterIdFittings implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => ['group' => 'fitting', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-fittings.write_fittings.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fittings.write_fittings.v1
     */
    public static function execute(EsiTransportInterface $transport, mixed $requestBody, int $characterId): EsiResult
    {
        $response = $transport->invoke('post', '/characters/{character_id}/fittings', ['character_id' => $characterId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, null, self::META);
    }
}
