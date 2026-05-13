<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\FleetsFleetIdMembersGetItem;

/**
 * ESI operation: getFleetsFleetIdMembers
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetFleetsFleetIdMembers implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 5, 'rateLimit' => ['group' => 'fleet', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-fleets.read_fleet.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<FleetsFleetIdMembersGetItem>>
     * @scope esi-fleets.read_fleet.v1
     */
    public static function execute(EsiTransportInterface $transport, int $fleetId): EsiResult
    {
        $response = $transport->invoke('get', '/fleets/{fleet_id}/members', ['fleet_id' => $fleetId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => FleetsFleetIdMembersGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
