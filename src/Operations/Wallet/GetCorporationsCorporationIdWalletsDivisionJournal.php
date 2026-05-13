<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Wallet;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CorporationsCorporationIdWalletsDivisionJournalGetItem;

/**
 * ESI operation: getCorporationsCorporationIdWalletsDivisionJournal
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCorporationsCorporationIdWalletsDivisionJournal implements EsiOperationInterface
{
    /** Required OAuth2 scope. Null for public endpoints. */
    public const ?string REQUIRED_SCOPE = 'esi-wallet.read_corporation_wallets.v1';

    /** Rate-limit group name (e.g. 'char-asset'). Null when not rate-limited. */
    public const ?string RATE_LIMIT_GROUP = 'corp-wallet';

    /** Maximum token bucket size for this rate-limit group. */
    public const ?int RATE_LIMIT_MAX_TOKENS = 300;

    /** Rate-limit window duration (e.g. '15m'). */
    public const ?string RATE_LIMIT_WINDOW = '15m';

    /** Cache TTL in seconds. Null for non-cached endpoints. */
    public const ?int CACHE_AGE = 3600;

    /**
     * EVE corporation roles required (e.g. ['Director']).
     *
     * @var list<string>
     */
    public const array REQUIRED_ROLES = ['Accountant', 'Junior_Accountant'];

    /** True for cursor-paginated endpoints. */
    public const bool USES_CURSOR = false;

    public static function meta(): OperationMeta
    {
        return new OperationMeta(
            requiredScope: self::REQUIRED_SCOPE,
            rateLimitGroup: self::RATE_LIMIT_GROUP,
            rateLimitMaxTokens: self::RATE_LIMIT_MAX_TOKENS,
            rateLimitWindow: self::RATE_LIMIT_WINDOW,
            cacheAge: self::CACHE_AGE,
            requiredRoles: self::REQUIRED_ROLES,
            usesCursor: self::USES_CURSOR,
        );
    }

    /**
     * @return EsiResult<array<CorporationsCorporationIdWalletsDivisionJournalGetItem>>
     * @scope esi-wallet.read_corporation_wallets.v1
     * @paginated Use $page param to iterate pages.
     */
    public static function execute(EsiTransportInterface $transport, int $corporationId, int $division, int $page = 1): EsiResult
    {
        $response = $transport->invoke('get', '/corporations/{corporation_id}/wallets/{division}/journal', ['corporation_id' => $corporationId, 'division' => $division], ['page' => $page]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CorporationsCorporationIdWalletsDivisionJournalGetItem::from($item),
            (array) $response->data,
        ), self::meta());
    }
}
