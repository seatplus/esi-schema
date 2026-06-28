<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\Resources\FreelanceJobs\GetCharactersFreelanceJobsListing;
use Seatplus\EsiSchema\Responses\CharactersFreelanceJobsListing;
use Seatplus\EsiSchema\Resources\FreelanceJobs\GetCharactersFreelanceJobsParticipation;
use Seatplus\EsiSchema\Responses\CharactersFreelanceJobsParticipation;
use Seatplus\EsiSchema\Resources\FreelanceJobs\GetCorporationsFreelanceJobsListing;
use Seatplus\EsiSchema\Responses\CorporationsFreelanceJobsListing;
use Seatplus\EsiSchema\Resources\FreelanceJobs\GetCorporationsFreelanceJobsParticipants;
use Seatplus\EsiSchema\Responses\CorporationsFreelanceJobsParticipants;
use Seatplus\EsiSchema\Resources\FreelanceJobs\GetFreelanceJobsListing;
use Seatplus\EsiSchema\Responses\FreelanceJobsListing;
use Seatplus\EsiSchema\Resources\FreelanceJobs\GetFreelanceJobsDetail;
use Seatplus\EsiSchema\Responses\FreelanceJobsDetail;

/**
 * ESI FreelanceJobs resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FreelanceJobsResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return CharactersFreelanceJobsListing
     * @scope esi-characters.read_freelance_jobs.v1
     */
    public function getCharactersFreelanceJobsListing(int $characterId): CharactersFreelanceJobsListing
    {
        return GetCharactersFreelanceJobsListing::execute($this->transport, $characterId);
    }

    /**
     * @return CharactersFreelanceJobsParticipation
     * @scope esi-characters.read_freelance_jobs.v1
     */
    public function getCharactersFreelanceJobsParticipation(int $characterId, string $jobId): CharactersFreelanceJobsParticipation
    {
        return GetCharactersFreelanceJobsParticipation::execute($this->transport, $characterId, $jobId);
    }

    /**
     * @return CorporationsFreelanceJobsListing
     * @scope esi-corporations.read_freelance_jobs.v1
     */
    public function getCorporationsFreelanceJobsListing(int $corporationId, ?string $after = null, ?string $before = null, ?int $limit = null): CorporationsFreelanceJobsListing
    {
        return GetCorporationsFreelanceJobsListing::execute($this->transport, $corporationId, $after, $before, $limit);
    }

    /**
     * @return CorporationsFreelanceJobsParticipants
     * @scope esi-corporations.read_freelance_jobs.v1
     */
    public function getCorporationsFreelanceJobsParticipants(int $corporationId, string $jobId, ?string $after = null, ?string $before = null, ?int $limit = null): CorporationsFreelanceJobsParticipants
    {
        return GetCorporationsFreelanceJobsParticipants::execute($this->transport, $corporationId, $jobId, $after, $before, $limit);
    }

    /**
     * @return FreelanceJobsListing
     */
    public function getFreelanceJobsListing(?string $after = null, ?string $before = null, ?int $limit = null, ?int $corporationId = null): FreelanceJobsListing
    {
        return GetFreelanceJobsListing::execute($this->transport, $after, $before, $limit, $corporationId);
    }

    /**
     * @return FreelanceJobsDetail
     */
    public function getFreelanceJobsDetail(string $jobId): FreelanceJobsDetail
    {
        return GetFreelanceJobsDetail::execute($this->transport, $jobId);
    }
}
