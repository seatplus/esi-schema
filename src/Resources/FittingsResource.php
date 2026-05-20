<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Fittings\GetCharactersCharacterIdFittings;
use Seatplus\EsiSchema\Resources\Fittings\PostCharactersCharacterIdFittings;
use Seatplus\EsiSchema\Resources\Fittings\DeleteCharactersCharacterIdFittingsFittingId;

/**
 * ESI Fittings resource — fluent wrapper around per-route static classes.
 *
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class FittingsResource
{
    public function __construct(private readonly EsiTransportInterface $transport)
    {
    }

    /**
     * @return EsiResult
     * @scope esi-fittings.read_fittings.v1
     */
    public function getCharactersCharacterIdFittings(int $characterId): EsiResult
    {
        return GetCharactersCharacterIdFittings::execute($this->transport, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-fittings.write_fittings.v1
     */
    public function postCharactersCharacterIdFittings(mixed $requestBody, int $characterId): EsiResult
    {
        return PostCharactersCharacterIdFittings::execute($this->transport, $requestBody, $characterId);
    }

    /**
     * @return EsiResult
     * @scope esi-fittings.write_fittings.v1
     */
    public function deleteCharactersCharacterIdFittingsFittingId(int $characterId, int $fittingId): EsiResult
    {
        return DeleteCharactersCharacterIdFittingsFittingId::execute($this->transport, $characterId, $fittingId);
    }
}
