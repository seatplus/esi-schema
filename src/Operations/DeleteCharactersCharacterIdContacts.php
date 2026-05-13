<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;

/**
 * ESI operation: deleteCharactersCharacterIdContacts
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class DeleteCharactersCharacterIdContacts implements EsiOperationInterface
{
    /** @var array<string,mixed> */
    private const array META = ['cacheAge' => null, 'rateLimit' => ['group' => 'char-social', 'max-tokens' => 600, 'window-size' => '15m'], 'requiredRoles' => [], 'cursor' => false, 'requiredScope' => 'esi-characters.write_contacts.v1'];

    public static function meta(): OperationMeta
    {
        return OperationMeta::from(self::META);
    }

    /**
     * @return EsiResult<null>
     * @scope esi-characters.write_contacts.v1
     */
    public static function execute(EsiTransportInterface $transport, int $characterId, array $contactIds): EsiResult
    {
        $response = $transport->invoke('delete', '/characters/{character_id}/contacts', ['character_id' => $characterId], ['contact_ids' => $contactIds], []);
        return EsiResult::fromRaw($response, null, self::META);
    }
}
