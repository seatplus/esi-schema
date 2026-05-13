<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\AlliancesAllianceIdContactsGetItem;

/**
 * ESI operation: getAlliancesAllianceIdContacts
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetAlliancesAllianceIdContacts implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 300, 'rateLimit' => ['group' => 'alliance-social', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-alliances.read_contacts.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<AlliancesAllianceIdContactsGetItem>>
     * @scope esi-alliances.read_contacts.v1
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $allianceId, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/alliances/{alliance_id}/contacts', ['alliance_id' => $allianceId], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => AlliancesAllianceIdContactsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
