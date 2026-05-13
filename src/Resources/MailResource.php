<?php

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMailGetItem;
use Seatplus\EsiSchema\Operations\Mail\GetCharactersCharacterIdMail;
use Seatplus\EsiSchema\Operations\Mail\PostCharactersCharacterIdMail;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMailLabelsGet;
use Seatplus\EsiSchema\Operations\Mail\GetCharactersCharacterIdMailLabels;
use Seatplus\EsiSchema\Operations\Mail\PostCharactersCharacterIdMailLabels;
use Seatplus\EsiSchema\Operations\Mail\DeleteCharactersCharacterIdMailLabelsLabelId;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMailListsGetItem;
use Seatplus\EsiSchema\Operations\Mail\GetCharactersCharacterIdMailLists;
use Seatplus\EsiSchema\Operations\Mail\DeleteCharactersCharacterIdMailMailId;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMailMailIdGet;
use Seatplus\EsiSchema\Operations\Mail\GetCharactersCharacterIdMailMailId;
use Seatplus\EsiSchema\Operations\Mail\PutCharactersCharacterIdMailMailId;

/**
 * ESI tag: Mail
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
class MailResource extends AbstractResource
{
    public static function metaFor(string $operationId): OperationMeta
    {
        return match ($operationId) {
            'getCharactersCharacterIdMail' => GetCharactersCharacterIdMail::meta(),
            'postCharactersCharacterIdMail' => PostCharactersCharacterIdMail::meta(),
            'getCharactersCharacterIdMailLabels' => GetCharactersCharacterIdMailLabels::meta(),
            'postCharactersCharacterIdMailLabels' => PostCharactersCharacterIdMailLabels::meta(),
            'deleteCharactersCharacterIdMailLabelsLabelId' => DeleteCharactersCharacterIdMailLabelsLabelId::meta(),
            'getCharactersCharacterIdMailLists' => GetCharactersCharacterIdMailLists::meta(),
            'deleteCharactersCharacterIdMailMailId' => DeleteCharactersCharacterIdMailMailId::meta(),
            'getCharactersCharacterIdMailMailId' => GetCharactersCharacterIdMailMailId::meta(),
            'putCharactersCharacterIdMailMailId' => PutCharactersCharacterIdMailMailId::meta(),
            default => new OperationMeta(),
        };
    }

    /** Pre-call metadata for getCharactersCharacterIdMail. Equivalent to GetCharactersCharacterIdMail::meta(). */
    public static function getCharactersCharacterIdMailMeta(): OperationMeta
    {
        return GetCharactersCharacterIdMail::meta();
    }

    /** Pre-call metadata for postCharactersCharacterIdMail. Equivalent to PostCharactersCharacterIdMail::meta(). */
    public static function postCharactersCharacterIdMailMeta(): OperationMeta
    {
        return PostCharactersCharacterIdMail::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdMailLabels. Equivalent to GetCharactersCharacterIdMailLabels::meta(). */
    public static function getCharactersCharacterIdMailLabelsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdMailLabels::meta();
    }

    /** Pre-call metadata for postCharactersCharacterIdMailLabels. Equivalent to PostCharactersCharacterIdMailLabels::meta(). */
    public static function postCharactersCharacterIdMailLabelsMeta(): OperationMeta
    {
        return PostCharactersCharacterIdMailLabels::meta();
    }

    /** Pre-call metadata for deleteCharactersCharacterIdMailLabelsLabelId. Equivalent to DeleteCharactersCharacterIdMailLabelsLabelId::meta(). */
    public static function deleteCharactersCharacterIdMailLabelsLabelIdMeta(): OperationMeta
    {
        return DeleteCharactersCharacterIdMailLabelsLabelId::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdMailLists. Equivalent to GetCharactersCharacterIdMailLists::meta(). */
    public static function getCharactersCharacterIdMailListsMeta(): OperationMeta
    {
        return GetCharactersCharacterIdMailLists::meta();
    }

    /** Pre-call metadata for deleteCharactersCharacterIdMailMailId. Equivalent to DeleteCharactersCharacterIdMailMailId::meta(). */
    public static function deleteCharactersCharacterIdMailMailIdMeta(): OperationMeta
    {
        return DeleteCharactersCharacterIdMailMailId::meta();
    }

    /** Pre-call metadata for getCharactersCharacterIdMailMailId. Equivalent to GetCharactersCharacterIdMailMailId::meta(). */
    public static function getCharactersCharacterIdMailMailIdMeta(): OperationMeta
    {
        return GetCharactersCharacterIdMailMailId::meta();
    }

    /** Pre-call metadata for putCharactersCharacterIdMailMailId. Equivalent to PutCharactersCharacterIdMailMailId::meta(). */
    public static function putCharactersCharacterIdMailMailIdMeta(): OperationMeta
    {
        return PutCharactersCharacterIdMailMailId::meta();
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdMailGetItem>>
     * @scope esi-mail.read_mail.v1
     */
    public function getCharactersCharacterIdMail(int $characterId, ?array $labels = null, ?int $lastMailId = null): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/mail', ['character_id' => $characterId], ['labels' => $labels, 'last_mail_id' => $lastMailId]);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdMailGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdMail::meta(),
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-mail.send_mail.v1
     */
    public function postCharactersCharacterIdMail(mixed $requestBody, int $characterId): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/mail', ['character_id' => $characterId], [], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostCharactersCharacterIdMail::meta(),
        );
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
        $dto->operationMeta = GetCharactersCharacterIdMailLabels::meta();
        return $dto;
    }

    /**
     * @return EsiResult<null>
     * @scope esi-mail.organize_mail.v1
     */
    public function postCharactersCharacterIdMailLabels(mixed $requestBody, int $characterId): EsiResult
    {
        $response = $this->transport->invoke('post', '/characters/{character_id}/mail/labels', ['character_id' => $characterId], [], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PostCharactersCharacterIdMailLabels::meta(),
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-mail.organize_mail.v1
     */
    public function deleteCharactersCharacterIdMailLabelsLabelId(int $characterId, int $labelId): EsiResult
    {
        $response = $this->transport->invoke('delete', '/characters/{character_id}/mail/labels/{label_id}', ['character_id' => $characterId, 'label_id' => $labelId], [], []);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: DeleteCharactersCharacterIdMailLabelsLabelId::meta(),
        );
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdMailListsGetItem>>
     * @scope esi-mail.read_mail.v1
     */
    public function getCharactersCharacterIdMailLists(int $characterId): EsiResult
    {
        $response = $this->transport->invoke('get', '/characters/{character_id}/mail/lists', ['character_id' => $characterId], []);
        return new EsiResult(
            data: array_map(
                fn (object $item) => CharactersCharacterIdMailListsGetItem::from($item),
                (array) $response->data,
            ),
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: GetCharactersCharacterIdMailLists::meta(),
        );
    }

    /**
     * @return EsiResult<null>
     * @scope esi-mail.organize_mail.v1
     */
    public function deleteCharactersCharacterIdMailMailId(int $characterId, int $mailId): EsiResult
    {
        $response = $this->transport->invoke('delete', '/characters/{character_id}/mail/{mail_id}', ['character_id' => $characterId, 'mail_id' => $mailId], [], []);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: DeleteCharactersCharacterIdMailMailId::meta(),
        );
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
        $dto->operationMeta = GetCharactersCharacterIdMailMailId::meta();
        return $dto;
    }

    /**
     * @return EsiResult<null>
     * @scope esi-mail.organize_mail.v1
     */
    public function putCharactersCharacterIdMailMailId(mixed $requestBody, int $characterId, int $mailId): EsiResult
    {
        $response = $this->transport->invoke('put', '/characters/{character_id}/mail/{mail_id}', ['character_id' => $characterId, 'mail_id' => $mailId], [], (array) $requestBody);
        return new EsiResult(
            data: null,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: PutCharactersCharacterIdMailMailId::meta(),
        );
    }
}
