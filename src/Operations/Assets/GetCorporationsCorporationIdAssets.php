<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Assets;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdAssetsGetItem;

/**
 * ESI operation: getCorporationsCorporationIdAssets
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdAssets implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'corp-asset', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => ['Director'], 'cursor' => false, 'requiredScope' => 'esi-assets.read_corporation_assets.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdAssetsGetItem>>
     * @scope esi-assets.read_corporation_assets.v1
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/assets', ['corporation_id' => $corporationId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdAssetsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
