<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Fleets;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;

/**
 * ESI operation: putFleetsFleetIdSquadsSquadId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class PutFleetsFleetIdSquadsSquadId implements EsiOperationInterface
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
    public static function execute(EsiTransportInterface $transport, mixed $requestBody, int $fleetId, int $squadId): EsiResult
    {
        $response = $transport->invoke('put', '/fleets/{fleet_id}/squads/{squad_id}', ['fleet_id' => $fleetId, 'squad_id' => $squadId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, null, self::META);
    }
}
