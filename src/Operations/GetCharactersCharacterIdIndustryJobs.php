<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdIndustryJobsGetItem;

/**
 * ESI operation: getCharactersCharacterIdIndustryJobs
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdIndustryJobs implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 300, 'rateLimit' => ['group' => 'char-industry', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-industry.read_character_jobs.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdIndustryJobsGetItem>>
     * @scope esi-industry.read_character_jobs.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, ?bool $includeCompleted = null): EsiResult
    {
        $response = $transport->invoke('get', '/characters/{character_id}/industry/jobs', ['character_id' => $characterId], ['include_completed' => $includeCompleted]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdIndustryJobsGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
