<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

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
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 60, 'rateLimit' => ['group' => 'char-freelance-job', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-characters.read_freelance_jobs.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
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
        $dto->operationMeta = self::META;
        return $dto;
    }
}
