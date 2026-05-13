<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\SovereigntyCampaignsGetItem;

/**
 * ESI operation: getSovereigntyCampaigns
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetSovereigntyCampaigns implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 5, 'rateLimit' => ['group' => 'sovereignty', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<SovereigntyCampaignsGetItem>>
     */
    public static function execute(EsiTransportInterface $transport): EsiResult
    {
        $response = $transport->invoke('get', '/sovereignty/campaigns', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => SovereigntyCampaignsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
