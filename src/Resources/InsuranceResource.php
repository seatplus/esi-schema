<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\InsurancePricesGetItem;

/**
 * ESI tag: Insurance
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class InsuranceResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getInsurancePrices' => ['cacheAge' => 3600, 'rateLimit' => ['group' => 'insurance', 'max-tokens' => 150, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false],
    ];

    /**
     * @return EsiResult<array<InsurancePricesGetItem>>
     */
    public function getInsurancePrices(): EsiResult
    {
        $response = $this->transport->invoke('get', '/insurance/prices', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => InsurancePricesGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getInsurancePrices'] ?? null);
    }
}
