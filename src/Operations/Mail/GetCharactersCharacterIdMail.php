<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Mail;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdMailGetItem;

/**
 * ESI operation: getCharactersCharacterIdMail
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class GetCharactersCharacterIdMail implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => 30, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-mail.read_mail.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<array<CharactersCharacterIdMailGetItem>>
     * @scope esi-mail.read_mail.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, ?array $labels = null, ?int $lastMailId = null): EsiResult
    {
        $response = $transport->invoke('get', '/characters/{character_id}/mail', ['character_id' => $characterId], ['labels' => $labels, 'last_mail_id' => $lastMailId]);
        return EsiResult::fromRaw($response, array_map(
            fn (object $item) => CharactersCharacterIdMailGetItem::from($item),
            (array) $response->data,
        ), self::META);
    }
}
