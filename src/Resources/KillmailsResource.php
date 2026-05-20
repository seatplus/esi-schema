<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Killmails\GetCharactersCharacterIdKillmailsRecent;
use Seatplus\EsiSchema\Resources\Killmails\GetCorporationsCorporationIdKillmailsRecent;
use Seatplus\EsiSchema\Resources\Killmails\GetKillmailsKillmailIdKillmailHash;
use Seatplus\EsiSchema\Responses\KillmailsKillmailIdKillmailHashGet;

/**
 * ESI Killmails resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class KillmailsResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     * @scope esi-killmails.read_killmails.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCharactersCharacterIdKillmailsRecent(int $characterId, int $page = 1): EsiResult
    {
        return GetCharactersCharacterIdKillmailsRecent::execute($this->transport, $characterId, $page);
    }

    /**
     * @return EsiResult
     * @scope esi-killmails.read_corporation_killmails.v1
     * @paginated Use $page param to iterate pages.
     */
    public function getCorporationsCorporationIdKillmailsRecent(int $corporationId, int $page = 1): EsiResult
    {
        return GetCorporationsCorporationIdKillmailsRecent::execute($this->transport, $corporationId, $page);
    }

    /**
     * @return KillmailsKillmailIdKillmailHashGet
     */
    public function getKillmailsKillmailIdKillmailHash(string $killmailHash, int $killmailId): KillmailsKillmailIdKillmailHashGet
    {
        return GetKillmailsKillmailIdKillmailHash::execute($this->transport, $killmailHash, $killmailId);
    }
}
