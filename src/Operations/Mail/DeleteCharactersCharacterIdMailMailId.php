<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Mail;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;

/**
 * ESI operation: deleteCharactersCharacterIdMailMailId
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class DeleteCharactersCharacterIdMailMailId implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-mail.organize_mail.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-mail.organize_mail.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, int $mailId): EsiResult
    {
        $response = $transport->invoke('delete', '/characters/{character_id}/mail/{mail_id}', ['character_id' => $characterId, 'mail_id' => $mailId], [], []);
        return EsiResult::fromRaw($response, null, self::META);
    }
}
