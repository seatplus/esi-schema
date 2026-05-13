<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\InsurancePricesGetItem;
use Seatplus\EsiSchema\Operations\Insurance\GetInsurancePrices;

/**
 * ESI tag: Insurance
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class InsuranceResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getInsurancePrices' => GetInsurancePrices::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getInsurancePrices. Equivalent to GetInsurancePrices::meta(). */
    public static function getInsurancePricesMeta(): OperationMeta
    {
        return GetInsurancePrices::meta();
    }

    /**
     * @return EsiResult<array<InsurancePricesGetItem>>
     */
    public function getInsurancePrices(): EsiResult
    {
        $response = $this->transport->invoke('get', '/insurance/prices', [], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => InsurancePricesGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
        );
    }
}
