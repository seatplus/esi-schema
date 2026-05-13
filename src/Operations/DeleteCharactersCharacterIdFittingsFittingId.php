<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;

/**
 * ESI operation: deleteCharactersCharacterIdFittingsFittingId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class DeleteCharactersCharacterIdFittingsFittingId implements EsiOperationInterface
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
    public static function execute(EsiTransportInterface $transport, int $characterId, int $fittingId): EsiResult
    {
        $response = $transport->invoke('delete', '/characters/{character_id}/fittings/{fitting_id}', ['character_id' => $characterId, 'fitting_id' => $fittingId], [], []);
        return EsiResult::fromRaw($response, null, self::META);
    }
}
