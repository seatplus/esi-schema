<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\Resources\AccessList\GetCharactersAccessListsListing;
use Seatplus\EsiSchema\Responses\CharactersAccessListsListing;
use Seatplus\EsiSchema\Resources\AccessList\GetCharactersAccessListsDetail;
use Seatplus\EsiSchema\Responses\CharactersAccessListsDetail;

/**
 * ESI AccessList resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-06-09).
 * Do not edit manually — run bin/generate.php instead.
 */
final class AccessListResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return CharactersAccessListsListing
     * @scope esi-access.read_lists.v1
     */
    public function getCharactersAccessListsListing(int $characterId): CharactersAccessListsListing
    {
        return GetCharactersAccessListsListing::execute($this->transport, $characterId);
    }

    /**
     * @return CharactersAccessListsDetail
     * @scope esi-access.read_lists.v1
     */
    public function getCharactersAccessListsDetail(int $accessListId, int $characterId): CharactersAccessListsDetail
    {
        return GetCharactersAccessListsDetail::execute($this->transport, $accessListId, $characterId);
    }
}
