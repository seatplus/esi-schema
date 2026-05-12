<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\IncursionsGetItem;

/**
 * ESI tag: Incursions
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class IncursionsResource extends AbstractResource
{
    /**
     * @return EsiResult<array<IncursionsGetItem>>
     */
    public function getIncursions(): EsiResult
    {
        $response = $this->transport->invoke('get', '/incursions', [], 'latest', []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => IncursionsGetItem::from($item),
            (array) $response->data,
        ));
    }
}
