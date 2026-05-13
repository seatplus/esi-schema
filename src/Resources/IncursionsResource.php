<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\IncursionsGetItem;
use Seatplus\EsiSchema\Operations\Incursions\GetIncursions;

/**
 * ESI tag: Incursions
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class IncursionsResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getIncursions' => GetIncursions::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getIncursions. Equivalent to GetIncursions::meta(). */
    public static function getIncursionsMeta(): OperationMeta
    {
        return GetIncursions::meta();
    }

    /**
     * @return EsiResult<array<IncursionsGetItem>>
     */
    public function getIncursions(): EsiResult
    {
        $response = $this->transport->invoke('get', '/incursions', [], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => IncursionsGetItem::from($item),
            (array) $response->data,
        ), GetIncursions::meta());
    }
}
