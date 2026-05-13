<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Operations\Wars\GetWars;
use Seatplus\EsiSchema\Responses\WarsWarIdGet;
use Seatplus\EsiSchema\Operations\Wars\GetWarsWarId;
use Seatplus\EsiSchema\Responses\WarsWarIdKillmailsGetItem;
use Seatplus\EsiSchema\Operations\Wars\GetWarsWarIdKillmails;

/**
 * ESI tag: Wars
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class WarsResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getWars' => GetWars::meta(),
            'getWarsWarId' => GetWarsWarId::meta(),
            'getWarsWarIdKillmails' => GetWarsWarIdKillmails::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getWars. Equivalent to GetWars::meta(). */
    public static function getWarsMeta(): OperationMeta
    {
        return GetWars::meta();
    }

    /** Pre-call metadata for getWarsWarId. Equivalent to GetWarsWarId::meta(). */
    public static function getWarsWarIdMeta(): OperationMeta
    {
        return GetWarsWarId::meta();
    }

    /** Pre-call metadata for getWarsWarIdKillmails. Equivalent to GetWarsWarIdKillmails::meta(). */
    public static function getWarsWarIdKillmailsMeta(): OperationMeta
    {
        return GetWarsWarIdKillmails::meta();
    }

    /**
     * @return EsiResult<array<int>>
     */
    public function getWars(?int $maxWarId = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/wars', [], ['max_war_id' => $maxWarId]);
        /** @var array<int> $data */
        $data = array_map(fn (mixed $i) => (int) $i, (array) $response->data);
        return new EsiResult(
            data: $data,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
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
        return new EsiResult(
            data: array_map(
                fn (object $item) => WarsWarIdKillmailsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }
}
