<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Contacts;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\AlliancesAllianceIdContactsLabelsGetItem;

/**
 * ESI operation: getAlliancesAllianceIdContactsLabels
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetAlliancesAllianceIdContactsLabels implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 300, 'rateLimit' => ['group' => 'alliance-social', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-alliances.read_contacts.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<AlliancesAllianceIdContactsLabelsGetItem>>
     * @scope esi-alliances.read_contacts.v1
     */
    public static function execute(EsiTransportInterface $transport, int $allianceId): EsiResult
    {
        $response = $transport->invoke('get', '/alliances/{alliance_id}/contacts/labels', ['alliance_id' => $allianceId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => AlliancesAllianceIdContactsLabelsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
