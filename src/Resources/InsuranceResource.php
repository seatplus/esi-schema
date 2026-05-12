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
    /**
     * @return EsiResult<array<InsurancePricesGetItem>>
     */
    public function getInsurancePrices(): EsiResult
    {
        $response = $this->transport->invoke('get', '/insurance/prices', [], 'latest', []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => InsurancePricesGetItem::from($item),
            (array) $response->data,
        ));
    }
}
