<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\FreelanceJobs;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersFreelanceJobsListing;

/**
 * ESI operation: getCharactersFreelanceJobsListing
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersFreelanceJobsListing implements EsiOperationInterface
{
    /** Required OAuth2 scope. Null for public endpoints. */
    public const ?string REQUIRED_SCOPE = 'esi-characters.read_freelance_jobs.v1';

    /** Rate-limit group name (e.g. 'char-asset'). Null when not rate-limited. */
    public const ?string RATE_LIMIT_GROUP = 'char-freelance-job';

    /** Maximum token bucket size for this rate-limit group. */
    public const ?int RATE_LIMIT_MAX_TOKENS = 300;

    /** Rate-limit window duration (e.g. '15m'). */
    public const ?string RATE_LIMIT_WINDOW = '15m';

    /** Cache TTL in seconds. Null for non-cached endpoints. */
    public const ?int CACHE_AGE = 60;

    /**
     * EVE corporation roles required (e.g. ['Director']).
     *
     * @var list<string>
     */
    public const array REQUIRED_ROLES = [];

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
     * @return CharactersFreelanceJobsListing
     * @scope esi-characters.read_freelance_jobs.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId): CharactersFreelanceJobsListing
    {
        $response = $transport->invoke('get', '/characters/{character_id}/freelance-jobs', ['character_id' => $characterId], []);
        $dto = CharactersFreelanceJobsListing::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::meta();
        return $dto;
    }
}
