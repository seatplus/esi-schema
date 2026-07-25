<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\Resources\Activities\GetCharactersMercenaryTacticalOperationsListing;
use Seatplus\EsiSchema\Responses\CharactersMercenaryTacticalOperationsListing;
use Seatplus\EsiSchema\Resources\Activities\GetCharactersMercenaryTacticalOperationsDetail;
use Seatplus\EsiSchema\Responses\CharactersMercenaryTacticalOperationsDetail;
use Seatplus\EsiSchema\Resources\Activities\GetSkyhooksRaidable;
use Seatplus\EsiSchema\Responses\SkyhooksRaidable;

/**
 * ESI Activities resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-21).
 * Do not edit manually — run bin/generate.php instead.
 */
final class ActivitiesResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return CharactersMercenaryTacticalOperationsListing
     * @scope esi-activities.read_character.v1
     */
    public function getCharactersMercenaryTacticalOperationsListing(int $characterId): CharactersMercenaryTacticalOperationsListing
    {
        return GetCharactersMercenaryTacticalOperationsListing::execute($this->transport, $characterId);
    }

    /**
     * @return CharactersMercenaryTacticalOperationsDetail
     * @scope esi-activities.read_character.v1
     */
    public function getCharactersMercenaryTacticalOperationsDetail(string $operationId, int $characterId): CharactersMercenaryTacticalOperationsDetail
    {
        return GetCharactersMercenaryTacticalOperationsDetail::execute($this->transport, $operationId, $characterId);
    }

    /**
     * @return SkyhooksRaidable
     */
    public function getSkyhooksRaidable(): SkyhooksRaidable
    {
        return GetSkyhooksRaidable::execute($this->transport);
    }
}
