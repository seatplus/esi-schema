<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Clones\GetCharactersCharacterIdClones;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdClonesGet;
use Seatplus\EsiSchema\Resources\Clones\GetCharactersCharacterIdImplants;

/**
 * ESI Clones resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class ClonesResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return CharactersCharacterIdClonesGet
     * @scope esi-clones.read_clones.v1
     */
    public function getCharactersCharacterIdClones(int $characterId): CharactersCharacterIdClonesGet
    {
        return GetCharactersCharacterIdClones::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-clones.read_implants.v1
     */
    public function getCharactersCharacterIdImplants(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdImplants::execute($this->transport, $characterId);
    }
}
