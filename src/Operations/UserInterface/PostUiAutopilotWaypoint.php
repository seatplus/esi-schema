<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\UserInterface;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;

/**
 * ESI operation: postUiAutopilotWaypoint
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class PostUiAutopilotWaypoint implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => ['group' => 'ui', 'max-tokens' => 900, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-ui.write_waypoint.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-ui.write_waypoint.v1
     */
    public static function execute(EsiTransportInterface $transport, bool $addToBeginning, bool $clearOtherWaypoints, int $destinationId): EsiResult
    {
        $response = $transport->invoke('post', '/ui/autopilot/waypoint', [], ['add_to_beginning' => $addToBeginning, 'clear_other_waypoints' => $clearOtherWaypoints, 'destination_id' => $destinationId], []);
        return EsiResult::fromRaw($response, null, self::META);
    }
}
