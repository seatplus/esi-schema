<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

use Seatplus\EsiSchema\Responses\CorporationsFreelanceJobsParticipantsParticipant;
use Seatplus\EsiSchema\Responses\Cursor;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CorporationsFreelanceJobsParticipants extends AbstractEsiDto
{
    public function __construct(
        public readonly array $participants,
        public readonly ?Cursor $cursor = null,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            participants: array_map(fn(object $i) => CorporationsFreelanceJobsParticipantsParticipant::from($i), (array) ($data->participants ?? [])),
            cursor: isset($data->cursor) ? Cursor::from($data->cursor) : null,
        );
    }
}