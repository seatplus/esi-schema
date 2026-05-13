<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Fleets;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;

/**
 * ESI operation: deleteFleetsFleetIdMembersMemberId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class DeleteFleetsFleetIdMembersMemberId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => ['group' => 'fleet', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-fleets.write_fleet.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-fleets.write_fleet.v1
     */
    public static function execute(EsiTransportInterface $transport, int $fleetId, int $memberId): EsiResult
    {
        $response = $transport->invoke('delete', '/fleets/{fleet_id}/members/{member_id}', ['fleet_id' => $fleetId, 'member_id' => $memberId], [], []);
        return EsiResult::fromRaw($response, null, self::META);
    }
}
