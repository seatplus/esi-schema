<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAttributesGet;
use Seatplus\EsiSchema\Operations\Skills\GetCharactersCharacterIdAttributes;
use Seatplus\EsiSchema\Operations\Skills\GetCharactersCharacterIdSkillqueue;
use Seatplus\EsiSchema\Responses\CharactersSkills;
use Seatplus\EsiSchema\Operations\Skills\GetCharactersCharacterIdSkills;

/**
 * ESI tag: Skills
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class SkillsResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdAttributes' => GetCharactersCharacterIdAttributes::meta(),
            'getCharactersCharacterIdSkillqueue' => GetCharactersCharacterIdSkillqueue::meta(),
            'getCharactersCharacterIdSkills' => GetCharactersCharacterIdSkills::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdAttributes. Equivalent to GetCharactersCharacterIdAttributes::meta(). */
    public static function getCharactersCharacterIdAttributesMeta(): OperationMeta
    {
        return GetCharactersCharacterIdAttributes::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdSkillqueue. Equivalent to GetCharactersCharacterIdSkillqueue::meta(). */
    public static function getCharactersCharacterIdSkillqueueMeta(): OperationMeta
    {
        return GetCharactersCharacterIdSkillqueue::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdSkills. Equivalent to GetCharactersCharacterIdSkills::meta(). */
    public static function getCharactersCharacterIdSkillsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdSkills::meta();
    }

    /**
     * @return CharactersCharacterIdAttributesGet
     * @scope esi-skills.read_skills.v1
     */
    public function getCharactersCharacterIdAttributes(int $characterId): CharactersCharacterIdAttributesGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/attributes', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdAttributesGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCharactersCharacterIdAttributes::meta();
        return $dto;
    }

    /**
     * @return EsiResult<null>
     * @scope esi-skills.read_skillqueue.v1
     */
    public function getCharactersCharacterIdSkillqueue(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/skillqueue', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, null, GetCharactersCharacterIdSkillqueue::meta());
    }

    /**
     * @return CharactersSkills
     * @scope esi-skills.read_skills.v1
     */
    public function getCharactersCharacterIdSkills(int $characterId): CharactersSkills
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/skills', ['character_id' => $characterId], []);
        $dto = CharactersSkills::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = GetCharactersCharacterIdSkills::meta();
        return $dto;
    }
}
