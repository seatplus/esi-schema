<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Industry;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\IndustryFacilitiesGetItem;

/**
 * ESI operation: getIndustryFacilities
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetIndustryFacilities implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'industry', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<IndustryFacilitiesGetItem>>
     */
    public static function execute(EsiTransportInterface $transport): EsiResult
    {
        $response = $transport->invoke('get', '/industry/facilities', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => IndustryFacilitiesGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
