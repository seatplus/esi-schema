<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersFreelanceJobsListing;
use Seatplus\EsiSchema\Operations\FreelanceJobs\GetCharactersFreelanceJobsListing;
use Seatplus\EsiSchema\Responses\CharactersFreelanceJobsParticipation;
use Seatplus\EsiSchema\Operations\FreelanceJobs\GetCharactersFreelanceJobsParticipation;
use Seatplus\EsiSchema\Responses\CorporationsFreelanceJobsListing;
use Seatplus\EsiSchema\Operations\FreelanceJobs\GetCorporationsFreelanceJobsListing;
use Seatplus\EsiSchema\Responses\CorporationsFreelanceJobsParticipants;
use Seatplus\EsiSchema\Operations\FreelanceJobs\GetCorporationsFreelanceJobsParticipants;
use Seatplus\EsiSchema\Responses\FreelanceJobsListing;
use Seatplus\EsiSchema\Operations\FreelanceJobs\GetFreelanceJobsListing;
use Seatplus\EsiSchema\Responses\FreelanceJobsDetail;
use Seatplus\EsiSchema\Operations\FreelanceJobs\GetFreelanceJobsDetail;

/**
 * ESI tag: FreelanceJobs
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class FreelanceJobsResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersFreelanceJobsListing' => GetCharactersFreelanceJobsListing::meta(),
            'getCharactersFreelanceJobsParticipation' => GetCharactersFreelanceJobsParticipation::meta(),
            'getCorporationsFreelanceJobsListing' => GetCorporationsFreelanceJobsListing::meta(),
            'getCorporationsFreelanceJobsParticipants' => GetCorporationsFreelanceJobsParticipants::meta(),
            'getFreelanceJobsListing' => GetFreelanceJobsListing::meta(),
            'getFreelanceJobsDetail' => GetFreelanceJobsDetail::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersFreelanceJobsListing. Equivalent to GetCharactersFreelanceJobsListing::meta(). */
    public static function getCharactersFreelanceJobsListingMeta(): OperationMeta
    {
        return GetCharactersFreelanceJobsListing::meta();
    }

    /** Pre-call metadata for getCharactersFreelanceJobsParticipation. Equivalent to GetCharactersFreelanceJobsParticipation::meta(). */
    public static function getCharactersFreelanceJobsParticipationMeta(): OperationMeta
    {
        return GetCharactersFreelanceJobsParticipation::meta();
    }

    /** Pre-call metadata for getCorporationsFreelanceJobsListing. Equivalent to GetCorporationsFreelanceJobsListing::meta(). */
    public static function getCorporationsFreelanceJobsListingMeta(): OperationMeta
    {
        return GetCorporationsFreelanceJobsListing::meta();
    }

    /** Pre-call metadata for getCorporationsFreelanceJobsParticipants. Equivalent to GetCorporationsFreelanceJobsParticipants::meta(). */
    public static function getCorporationsFreelanceJobsParticipantsMeta(): OperationMeta
    {
        return GetCorporationsFreelanceJobsParticipants::meta();
    }

    /** Pre-call metadata for getFreelanceJobsListing. Equivalent to GetFreelanceJobsListing::meta(). */
    public static function getFreelanceJobsListingMeta(): OperationMeta
    {
        return GetFreelanceJobsListing::meta();
    }

    /** Pre-call metadata for getFreelanceJobsDetail. Equivalent to GetFreelanceJobsDetail::meta(). */
    public static function getFreelanceJobsDetailMeta(): OperationMeta
    {
        return GetFreelanceJobsDetail::meta();
    }

    /**
     * @return CharactersFreelanceJobsListing
     * @scope esi-characters.read_freelance_jobs.v1
     */
    public function getCharactersFreelanceJobsListing(int $characterId): CharactersFreelanceJobsListing
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/freelance-jobs', ['character_id' => $characterId], []);
        $dto = CharactersFreelanceJobsListing::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return CharactersFreelanceJobsParticipation
     * @scope esi-characters.read_freelance_jobs.v1
     */
    public function getCharactersFreelanceJobsParticipation(int $characterId, string $jobId): CharactersFreelanceJobsParticipation
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/freelance-jobs/{job_id}/participation', ['character_id' => $characterId, 'job_id' => $jobId], []);
        $dto = CharactersFreelanceJobsParticipation::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return CorporationsFreelanceJobsListing
     * @scope esi-corporations.read_freelance_jobs.v1
     */
    public function getCorporationsFreelanceJobsListing(int $corporationId, ?string $after = null, ?string $before = null, ?int $limit = null): CorporationsFreelanceJobsListing
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/freelance-jobs', ['corporation_id' => $corporationId], ['after' => $after, 'before' => $before, 'limit' => $limit]);
        $dto = CorporationsFreelanceJobsListing::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return CorporationsFreelanceJobsParticipants
     * @scope esi-corporations.read_freelance_jobs.v1
     */
    public function getCorporationsFreelanceJobsParticipants(int $corporationId, string $jobId, ?string $after = null, ?string $before = null, ?int $limit = null): CorporationsFreelanceJobsParticipants
    {
        $response = $this->transport->invoke('get', '/corporations/{corporation_id}/freelance-jobs/{job_id}/participants', ['corporation_id' => $corporationId, 'job_id' => $jobId], ['after' => $after, 'before' => $before, 'limit' => $limit]);
        $dto = CorporationsFreelanceJobsParticipants::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return FreelanceJobsListing
     */
    public function getFreelanceJobsListing(?string $after = null, ?string $before = null, ?int $limit = null, ?int $corporationId = null): FreelanceJobsListing
    {
        $response = $this->transport->invoke('get', '/freelance-jobs', [], ['after' => $after, 'before' => $before, 'limit' => $limit, 'corporation_id' => $corporationId]);
        $dto = FreelanceJobsListing::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }

    /**
     * @return FreelanceJobsDetail
     */
    public function getFreelanceJobsDetail(string $jobId): FreelanceJobsDetail
    {
        $response = $this->transport->invoke('get', '/freelance-jobs/{job_id}', ['job_id' => $jobId], []);
        $dto = FreelanceJobsDetail::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        return $dto;
    }
}
