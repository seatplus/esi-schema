<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\WarsWarIdKillmailsGetItem;

/**
 * ESI operation: getWarsWarIdKillmails
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetWarsWarIdKillmails implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 3600, 'rateLimit' => ['group' => 'killmail', 'max-tokens' => 3600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<WarsWarIdKillmailsGetItem>>
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $warId, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/wars/{war_id}/killmails', ['war_id' => $warId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => WarsWarIdKillmailsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
