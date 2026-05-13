<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\UserInterface\PostUiAutopilotWaypoint;
use Seatplus\EsiSchema\Resources\UserInterface\PostUiOpenwindowContract;
use Seatplus\EsiSchema\Resources\UserInterface\PostUiOpenwindowInformation;
use Seatplus\EsiSchema\Resources\UserInterface\PostUiOpenwindowMarketdetails;
use Seatplus\EsiSchema\Resources\UserInterface\PostUiOpenwindowNewmail;

/**
 * ESI UserInterface resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class UserInterfaceResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     * @scope esi-ui.write_waypoint.v1
     */
    public function postUiAutopilotWaypoint(bool $addToBeginning, bool $clearOtherWaypoints, int $destinationId): EsiResult
    {
        return PostUiAutopilotWaypoint::execute($this->transport, $addToBeginning, $clearOtherWaypoints, $destinationId);
    }

    /**
     * @return EsiResult
     * @scope esi-ui.open_window.v1
     */
    public function postUiOpenwindowContract(int $contractId): EsiResult
    {
        return PostUiOpenwindowContract::execute($this->transport, $contractId);
    }

    /**
     * @return EsiResult
     * @scope esi-ui.open_window.v1
     */
    public function postUiOpenwindowInformation(int $targetId): EsiResult
    {
        return PostUiOpenwindowInformation::execute($this->transport, $targetId);
    }

    /**
     * @return EsiResult
     * @scope esi-ui.open_window.v1
     */
    public function postUiOpenwindowMarketdetails(int $typeId): EsiResult
    {
        return PostUiOpenwindowMarketdetails::execute($this->transport, $typeId);
    }

    /**
     * @return EsiResult
     * @scope esi-ui.open_window.v1
     */
    public function postUiOpenwindowNewmail(mixed $requestBody): EsiResult
    {
        return PostUiOpenwindowNewmail::execute($this->transport, $requestBody);
    }
}
