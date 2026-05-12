<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAttributesGet;
use Seatplus\EsiSchema\Responses\CharactersSkills;

/**
 * ESI tag: Skills
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class SkillsResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCharactersCharacterIdAttributes' => ['cacheAge' => 120, 'rateLimit' => ['group' => 'char-detail', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-skills.read_skills.v1'],
        'getCharactersCharacterIdSkillqueue' => ['cacheAge' => 60, 'rateLimit' => ['group' => 'char-detail', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-skills.read_skillqueue.v1'],
        'getCharactersCharacterIdSkills' => ['cacheAge' => 60, 'rateLimit' => ['group' => 'char-detail', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-skills.read_skills.v1'],
    ];

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
        $dto->operationMeta = static::OPERATION_META['getCharactersCharacterIdAttributes'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<null>
     * @scope esi-skills.read_skillqueue.v1
     */
    public function getCharactersCharacterIdSkillqueue(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/skillqueue', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, null, static::OPERATION_META['getCharactersCharacterIdSkillqueue'] ?? null);
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
        $dto->operationMeta = static::OPERATION_META['getCharactersCharacterIdSkills'] ?? null;
        return $dto;
    }
}
