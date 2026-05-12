<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\WarsWarIdGet;
use Seatplus\EsiSchema\Responses\WarsWarIdKillmailsGetItem;

/**
 * ESI tag: Wars
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class WarsResource extends AbstractResource
{
    /**
     * @return EsiResult<array<int>>
     */
    public function getWars(?int $maxWarId = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/wars', [], ['max_war_id' => $maxWarId]);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return EsiResult::fromRaw($response, $data);
    }

    /**
     * @return WarsWarIdGet
     */
    public function getWarsWarId(int $warId): WarsWarIdGet
    {
        $response = $this->transport->invoke('get', '/wars/{war_id}', ['war_id' => $warId], []);
        $dto = WarsWarIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return EsiResult<array<WarsWarIdKillmailsGetItem>>
     * @paginated Use $page param to iterate pages.
     */
    public function getWarsWarIdKillmails(int $warId, int $page = 1): EsiResult
    {
        $response = $this->transport->invoke('get', '/wars/{war_id}/killmails', ['war_id' => $warId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => WarsWarIdKillmailsGetItem::from($item),
            (array) $response->data,
        ));
    }
}
