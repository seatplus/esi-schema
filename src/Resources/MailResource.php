<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMailGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMailLabelsGet;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMailListsGetItem;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMailMailIdGet;

/**
 * ESI tag: Mail
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class MailResource extends AbstractResource
{
    protected const array OPERATION_META = [
        'getCharactersCharacterIdMail' => ['cacheAge' => 30, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-mail.read_mail.v1'],
        'postCharactersCharacterIdMail' => ['cacheAge' => null, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-mail.send_mail.v1'],
        'getCharactersCharacterIdMailLabels' => ['cacheAge' => 30, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-mail.read_mail.v1'],
        'postCharactersCharacterIdMailLabels' => ['cacheAge' => null, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-mail.organize_mail.v1'],
        'deleteCharactersCharacterIdMailLabelsLabelId' => ['cacheAge' => null, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-mail.organize_mail.v1'],
        'getCharactersCharacterIdMailLists' => ['cacheAge' => 120, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-mail.read_mail.v1'],
        'deleteCharactersCharacterIdMailMailId' => ['cacheAge' => null, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-mail.organize_mail.v1'],
        'getCharactersCharacterIdMailMailId' => ['cacheAge' => 30, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-mail.read_mail.v1'],
        'putCharactersCharacterIdMailMailId' => ['cacheAge' => null, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-mail.organize_mail.v1'],
    ];

    /**
     * @return EsiResult<array<CharactersCharacterIdMailGetItem>>
     * @scope esi-mail.read_mail.v1
     */
    public function getCharactersCharacterIdMail(int $characterId, ?array $labels = null, ?int $lastMailId = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/mail', ['character_id' => $characterId], ['labels' => $labels, 'last_mail_id' => $lastMailId]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdMailGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdMail'] ?? null);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-mail.send_mail.v1
     */
    public function postCharactersCharacterIdMail(mixed $requestBody, int $characterId): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/mail', ['character_id' => $characterId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, null, static::OPERATION_META['postCharactersCharacterIdMail'] ?? null);
    }

    /**
     * @return CharactersCharacterIdMailLabelsGet
     * @scope esi-mail.read_mail.v1
     */
    public function getCharactersCharacterIdMailLabels(int $characterId): CharactersCharacterIdMailLabelsGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/mail/labels', ['character_id' => $characterId], []);
        $dto = CharactersCharacterIdMailLabelsGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getCharactersCharacterIdMailLabels'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<null>
     * @scope esi-mail.organize_mail.v1
     */
    public function postCharactersCharacterIdMailLabels(mixed $requestBody, int $characterId): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/mail/labels', ['character_id' => $characterId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, null, static::OPERATION_META['postCharactersCharacterIdMailLabels'] ?? null);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-mail.organize_mail.v1
     */
    public function deleteCharactersCharacterIdMailLabelsLabelId(int $characterId, int $labelId): EsiResult
    {
        $response = $this->transport->invoke('delete', '/characters/{character_id}/mail/labels/{label_id}', ['character_id' => $characterId, 'label_id' => $labelId], [], []);
        return EsiResult::fromRaw($response, null, static::OPERATION_META['deleteCharactersCharacterIdMailLabelsLabelId'] ?? null);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdMailListsGetItem>>
     * @scope esi-mail.read_mail.v1
     */
    public function getCharactersCharacterIdMailLists(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/mail/lists', ['character_id' => $characterId], []);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdMailListsGetItem::from($item),
            (array) $response->data,
        ), static::OPERATION_META['getCharactersCharacterIdMailLists'] ?? null);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-mail.organize_mail.v1
     */
    public function deleteCharactersCharacterIdMailMailId(int $characterId, int $mailId): EsiResult
    {
        $response = $this->transport->invoke('delete', '/characters/{character_id}/mail/{mail_id}', ['character_id' => $characterId, 'mail_id' => $mailId], [], []);
        return EsiResult::fromRaw($response, null, static::OPERATION_META['deleteCharactersCharacterIdMailMailId'] ?? null);
    }

    /**
     * @return CharactersCharacterIdMailMailIdGet
     * @scope esi-mail.read_mail.v1
     */
    public function getCharactersCharacterIdMailMailId(int $characterId, int $mailId): CharactersCharacterIdMailMailIdGet
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/mail/{mail_id}', ['character_id' => $characterId, 'mail_id' => $mailId], []);
        $dto = CharactersCharacterIdMailMailIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = static::OPERATION_META['getCharactersCharacterIdMailMailId'] ?? null;
        return $dto;
    }

    /**
     * @return EsiResult<null>
     * @scope esi-mail.organize_mail.v1
     */
    public function putCharactersCharacterIdMailMailId(mixed $requestBody, int $characterId, int $mailId): EsiResult
    {
        $response = $this->transport->invoke('put', '/characters/{character_id}/mail/{mail_id}', ['character_id' => $characterId, 'mail_id' => $mailId], [], (array) $requestBody);
        return EsiResult::fromRaw($response, null, static::OPERATION_META['putCharactersCharacterIdMailMailId'] ?? null);
    }
}
