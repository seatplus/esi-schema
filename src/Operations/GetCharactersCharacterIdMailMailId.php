<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMailMailIdGet;

/**
 * ESI operation: getCharactersCharacterIdMailMailId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdMailMailId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 30, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-mail.read_mail.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return CharactersCharacterIdMailMailIdGet
     * @scope esi-mail.read_mail.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, int $mailId): CharactersCharacterIdMailMailIdGet
    {
        $response = $transport->invoke('get', '/characters/{character_id}/mail/{mail_id}', ['character_id' => $characterId, 'mail_id' => $mailId], []);
        $dto = CharactersCharacterIdMailMailIdGet::from((object) $response->data);
        $dto->isCachedLoad = $response->isCachedLoad;
        $dto->pages = $response->pages;
        $dto->operationMeta = self::META;
        return $dto;
    }
}
