<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;

/**
 * ESI tag: UserInterface
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class UserInterfaceResource extends AbstractResource
{
    /**
     * @return EsiResult<null>
     * @scope esi-ui.write_waypoint.v1
     */
    public function postUiAutopilotWaypoint(bool $addToBeginning, bool $clearOtherWaypoints, int $destinationId): EsiResult
    {
        $response = $this->transport->invoke('post', '/ui/autopilot/waypoint', [], ['add_to_beginning' => $addToBeginning, 'clear_other_waypoints' => $clearOtherWaypoints, 'destination_id' => $destinationId], []);
        return EsiResult::fromRaw($response, null);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-ui.open_window.v1
     */
    public function postUiOpenwindowContract(int $contractId): EsiResult
    {
        $response = $this->transport->invoke('post', '/ui/openwindow/contract', [], ['contract_id' => $contractId], []);
        return EsiResult::fromRaw($response, null);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-ui.open_window.v1
     */
    public function postUiOpenwindowInformation(int $targetId): EsiResult
    {
        $response = $this->transport->invoke('post', '/ui/openwindow/information', [], ['target_id' => $targetId], []);
        return EsiResult::fromRaw($response, null);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-ui.open_window.v1
     */
    public function postUiOpenwindowMarketdetails(int $typeId): EsiResult
    {
        $response = $this->transport->invoke('post', '/ui/openwindow/marketdetails', [], ['type_id' => $typeId], []);
        return EsiResult::fromRaw($response, null);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-ui.open_window.v1
     */
    public function postUiOpenwindowNewmail(mixed $requestBody): EsiResult
    {
        $response = $this->transport->invoke('post', '/ui/openwindow/newmail', [], [], (array) $requestBody);
        return EsiResult::fromRaw($response, null);
    }
}
