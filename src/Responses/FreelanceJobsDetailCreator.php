<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

use Seatplus\EsiSchema\Responses\FreelanceJobsDetailCreatorcharacter;
use Seatplus\EsiSchema\Responses\FreelanceJobsDetailCreatorcorporation;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FreelanceJobsDetailCreator extends AbstractEsiDto
{
    public function __construct(
        public readonly FreelanceJobsDetailCreatorcharacter $character,
        public readonly FreelanceJobsDetailCreatorcorporation $corporation,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            character: FreelanceJobsDetailCreatorcharacter::from($data->character ?? new \stdClass()),
            corporation: FreelanceJobsDetailCreatorcorporation::from($data->corporation ?? new \stdClass()),
        );
    }
}