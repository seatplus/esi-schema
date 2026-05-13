<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Corporation;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdMembersTitlesGetItem;

/**
 * ESI operation: getCorporationsCorporationIdMembersTitles
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdMembersTitles implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'corp-member', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => ['Director'], 'cursor' => false, 'requiredScope' => 'esi-corporations.read_titles.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdMembersTitlesGetItem>>
     * @scope esi-corporations.read_titles.v1
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId): EsiResult
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/members/titles', ['corporation_id' => $corporationId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdMembersTitlesGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
