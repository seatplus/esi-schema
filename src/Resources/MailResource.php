<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Mail\GetCharactersCharacterIdMail;
use Seatplus\EsiSchema\Resources\Mail\PostCharactersCharacterIdMail;
use Seatplus\EsiSchema\Resources\Mail\GetCharactersCharacterIdMailLabels;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMailLabelsGet;
use Seatplus\EsiSchema\Resources\Mail\PostCharactersCharacterIdMailLabels;
use Seatplus\EsiSchema\Resources\Mail\DeleteCharactersCharacterIdMailLabelsLabelId;
use Seatplus\EsiSchema\Resources\Mail\GetCharactersCharacterIdMailLists;
use Seatplus\EsiSchema\Resources\Mail\DeleteCharactersCharacterIdMailMailId;
use Seatplus\EsiSchema\Resources\Mail\GetCharactersCharacterIdMailMailId;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMailMailIdGet;
use Seatplus\EsiSchema\Resources\Mail\PutCharactersCharacterIdMailMailId;

/**
 * ESI Mail resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class MailResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     * @scope esi-mail.read_mail.v1
     */
    public function getCharactersCharacterIdMail(int $characterId, ?array $labels = null, ?int $lastMailId = null): EsiResult
    {
        return GetCharactersCharacterIdMail::execute($this->transport, $characterId, $labels, $lastMailId);
    }

    /**
     * @return EsiResult
     * @scope esi-mail.send_mail.v1
     */
    public function postCharactersCharacterIdMail(mixed $requestBody, int $characterId): EsiResult
    {
        return PostCharactersCharacterIdMail::execute($this->transport, $requestBody, $characterId);
    }

    /**
     * @return CharactersCharacterIdMailLabelsGet
     * @scope esi-mail.read_mail.v1
     */
    public function getCharactersCharacterIdMailLabels(int $characterId): CharactersCharacterIdMailLabelsGet
    {
        return GetCharactersCharacterIdMailLabels::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-mail.organize_mail.v1
     */
    public function postCharactersCharacterIdMailLabels(mixed $requestBody, int $characterId): EsiResult
    {
        return PostCharactersCharacterIdMailLabels::execute($this->transport, $requestBody, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-mail.organize_mail.v1
     */
    public function deleteCharactersCharacterIdMailLabelsLabelId(int $characterId, int $labelId): EsiResult
    {
        return DeleteCharactersCharacterIdMailLabelsLabelId::execute($this->transport, $characterId, $labelId);
    }

    /**
     * @return EsiResult
     * @scope esi-mail.read_mail.v1
     */
    public function getCharactersCharacterIdMailLists(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdMailLists::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-mail.organize_mail.v1
     */
    public function deleteCharactersCharacterIdMailMailId(int $characterId, int $mailId): EsiResult
    {
        return DeleteCharactersCharacterIdMailMailId::execute($this->transport, $characterId, $mailId);
    }

    /**
     * @return CharactersCharacterIdMailMailIdGet
     * @scope esi-mail.read_mail.v1
     */
    public function getCharactersCharacterIdMailMailId(int $characterId, int $mailId): CharactersCharacterIdMailMailIdGet
    {
        return GetCharactersCharacterIdMailMailId::execute($this->transport, $characterId, $mailId);
    }

    /**
     * @return EsiResult
     * @scope esi-mail.organize_mail.v1
     */
    public function putCharactersCharacterIdMailMailId(mixed $requestBody, int $characterId, int $mailId): EsiResult
    {
        return PutCharactersCharacterIdMailMailId::execute($this->transport, $requestBody, $characterId, $mailId);
    }
}
