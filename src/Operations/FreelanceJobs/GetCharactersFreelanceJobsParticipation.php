<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\FreelanceJobs;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersFreelanceJobsParticipation;

/**
 * ESI operation: getCharactersFreelanceJobsParticipation
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersFreelanceJobsParticipation implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 60, 'rateLimit' => ['group' => 'char-freelance-job', 'max-tokens' => 300, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-characters.read_freelance_jobs.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CharactersFreelanceJobsParticipation
     * @scope esi-characters.read_freelance_jobs.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, string $jobId): CharactersFreelanceJobsParticipation
    {
        $response = $transport->invoke('get', '/characters/{character_id}/freelance-jobs/{job_id}/participation', ['character_id' => $characterId, 'job_id' => $jobId], []);
        $dto = CharactersFreelanceJobsParticipation::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
