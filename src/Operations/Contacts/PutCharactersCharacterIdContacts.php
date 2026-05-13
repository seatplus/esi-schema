<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Operations\Contacts;

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;

/**
 * ESI operation: putCharactersCharacterIdContacts
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class PutCharactersCharacterIdContacts implements EsiOperationInterface
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
    public static function execute(EsiTransportInterface $transport, mixed $requestBody, int $characterId, float $standing, ?array $labelIds = null, ?bool $watched = null): EsiResult
    {
        $response = $transport->invoke('put', '/characters/{character_id}/contacts', ['character_id' => $characterId], ['label_ids' => $labelIds, 'standing' => $standing, 'watched' => $watched], (array) $requestBody);
        return EsiResult::fromRaw($response, null, self::META);
    }
}
