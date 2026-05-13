<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\KillmailsKillmailIdKillmailHashGet;

/**
 * ESI operation: getKillmailsKillmailIdKillmailHash
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetKillmailsKillmailIdKillmailHash implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 2592000, 'rateLimit' => ['group' => 'killmail', 'max-tokens' => 3600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => null];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return KillmailsKillmailIdKillmailHashGet
     */
    public static function execute(EsiTransportInterface $transport, string $killmailHash, int $killmailId): KillmailsKillmailIdKillmailHashGet
    {
        $response = $transport->invoke('get', '/killmails/{killmail_id}/{killmail_hash}', ['killmail_hash' => $killmailHash, 'killmail_id' => $killmailId], []);
        $dto = KillmailsKillmailIdKillmailHashGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
