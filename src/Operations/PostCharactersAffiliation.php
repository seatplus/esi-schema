<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersAffiliationPostItem;

/**
 * ESI operation: postCharactersAffiliation
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class PostCharactersAffiliation implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => null, 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersAffiliationPostItem>>
     */
    public static function execute(EsiTransportInterface $transport, mixed $requestBody): EsiResult
    {
        $response = $transport->invoke('post', '/characters/affiliation', [], [], (array) $requestBody);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersAffiliationPostItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
