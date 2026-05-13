<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Fleets;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;

/**
 * ESI operation: putFleetsFleetIdWingsWingId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class PutFleetsFleetIdWingsWingId implements EsiOperationInterface
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
    public static function execute(EsiTransportInterface $transport, mixed $requestBody, int $fleetId, int $wingId): EsiResult
    {
        $response = $transport->invoke('put', '/fleets/{fleet_id}/wings/{wing_id}', ['fleet_id' => $fleetId, 'wing_id' => $wingId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, null, self::META);
    }
}
