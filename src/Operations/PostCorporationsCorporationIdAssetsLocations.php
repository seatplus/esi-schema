<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdAssetsLocationsPostItem;

/**
 * ESI operation: postCorporationsCorporationIdAssetsLocations
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class PostCorporationsCorporationIdAssetsLocations implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => ['group' => 'corp-asset', 'max-tokens' => 1800, 'window-size' => '15m'], 'requiredRoles' => ['Director'], 'cursor' => false, 'requiredScope' => 'esi-assets.read_corporation_assets.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdAssetsLocationsPostItem>>
     * @scope esi-assets.read_corporation_assets.v1
     */
    public static function execute(EsiTransportInterface $transport, mixed $requestBody, int $corporationId): EsiResult
    {
        $response = $transport->invoke('post', '/corporations/{corporation_id}/assets/locations', ['corporation_id' => $corporationId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdAssetsLocationsPostItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
