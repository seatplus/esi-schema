<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Operations\UserInterface\PostUiAutopilotWaypoint;
use Seatplus\EsiSchema\Operations\UserInterface\PostUiOpenwindowContract;
use Seatplus\EsiSchema\Operations\UserInterface\PostUiOpenwindowInformation;
use Seatplus\EsiSchema\Operations\UserInterface\PostUiOpenwindowMarketdetails;
use Seatplus\EsiSchema\Operations\UserInterface\PostUiOpenwindowNewmail;

/**
 * ESI tag: UserInterface
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class UserInterfaceResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'postUiAutopilotWaypoint' => PostUiAutopilotWaypoint::meta(),
            'postUiOpenwindowContract' => PostUiOpenwindowContract::meta(),
            'postUiOpenwindowInformation' => PostUiOpenwindowInformation::meta(),
            'postUiOpenwindowMarketdetails' => PostUiOpenwindowMarketdetails::meta(),
            'postUiOpenwindowNewmail' => PostUiOpenwindowNewmail::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for postUiAutopilotWaypoint. Equivalent to PostUiAutopilotWaypoint::meta(). */
    public static function postUiAutopilotWaypointMeta(): OperationMeta
    {
        return PostUiAutopilotWaypoint::meta();
    }

    /** Pre-call metadata for postUiOpenwindowContract. Equivalent to PostUiOpenwindowContract::meta(). */
    public static function postUiOpenwindowContractMeta(): OperationMeta
    {
        return PostUiOpenwindowContract::meta();
    }

    /** Pre-call metadata for postUiOpenwindowInformation. Equivalent to PostUiOpenwindowInformation::meta(). */
    public static function postUiOpenwindowInformationMeta(): OperationMeta
    {
        return PostUiOpenwindowInformation::meta();
    }

    /** Pre-call metadata for postUiOpenwindowMarketdetails. Equivalent to PostUiOpenwindowMarketdetails::meta(). */
    public static function postUiOpenwindowMarketdetailsMeta(): OperationMeta
    {
        return PostUiOpenwindowMarketdetails::meta();
    }

    /** Pre-call metadata for postUiOpenwindowNewmail. Equivalent to PostUiOpenwindowNewmail::meta(). */
    public static function postUiOpenwindowNewmailMeta(): OperationMeta
    {
        return PostUiOpenwindowNewmail::meta();
    }

    /**
     * @return EsiResult<null>
     * @scope esi-ui.write_waypoint.v1
     */
    public function postUiAutopilotWaypoint(bool $addToBeginning, bool $clearOtherWaypoints, int $destinationId): EsiResult
    {
        $response = $this->transport->invoke('post', '/ui/autopilot/waypoint', [], ['add_to_beginning' => $addToBeginning, 'clear_other_waypoints' => $clearOtherWaypoints, 'destination_id' => $destinationId], []);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostUiAutopilotWaypoint::meta(),
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-ui.open_window.v1
     */
    public function postUiOpenwindowContract(int $contractId): EsiResult
    {
        $response = $this->transport->invoke('post', '/ui/openwindow/contract', [], ['contract_id' => $contractId], []);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostUiOpenwindowContract::meta(),
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-ui.open_window.v1
     */
    public function postUiOpenwindowInformation(int $targetId): EsiResult
    {
        $response = $this->transport->invoke('post', '/ui/openwindow/information', [], ['target_id' => $targetId], []);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostUiOpenwindowInformation::meta(),
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-ui.open_window.v1
     */
    public function postUiOpenwindowMarketdetails(int $typeId): EsiResult
    {
        $response = $this->transport->invoke('post', '/ui/openwindow/marketdetails', [], ['type_id' => $typeId], []);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostUiOpenwindowMarketdetails::meta(),
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-ui.open_window.v1
     */
    public function postUiOpenwindowNewmail(mixed $requestBody): EsiResult
    {
        $response = $this->transport->invoke('post', '/ui/openwindow/newmail', [], [], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostUiOpenwindowNewmail::meta(),
        );
    }
}
