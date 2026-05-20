<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Skills\GetCharactersCharacterIdAttributes;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAttributesGet;
use Seatplus\EsiSchema\Resources\Skills\GetCharactersCharacterIdSkillqueue;
use Seatplus\EsiSchema\Resources\Skills\GetCharactersCharacterIdSkills;
use Seatplus\EsiSchema\Responses\CharactersSkills;

/**
 * ESI Skills resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class SkillsResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return CharactersCharacterIdAttributesGet
     * @scope esi-skills.read_skills.v1
     */
    public function getCharactersCharacterIdAttributes(int $characterId): CharactersCharacterIdAttributesGet
    {
        return GetCharactersCharacterIdAttributes::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-skills.read_skillqueue.v1
     */
    public function getCharactersCharacterIdSkillqueue(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdSkillqueue::execute($this->transport, $characterId);
    }

    /**
     * @return CharactersSkills
     * @scope esi-skills.read_skills.v1
     */
    public function getCharactersCharacterIdSkills(int $characterId): CharactersSkills
    {
        return GetCharactersCharacterIdSkills::execute($this->transport, $characterId);
    }
}
