<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Universe;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\UniverseNamesPostItem;

/**
 * ESI operation: postUniverseNames
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class PostUniverseNames implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<UniverseNamesPostItem>>
     */
    public static function execute(EsiTransportInterface $transport, mixed $requestBody): EsiResult
    {
        $response = $transport->invoke('post', '/universe/names', [], [], (array) $requestBody);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => UniverseNamesPostItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
