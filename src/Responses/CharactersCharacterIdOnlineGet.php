<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-05-19).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdOnlineGet extends AbstractEsiDto
{
    public function __construct(
        public readonly bool $online,
        public readonly ?string $last_login = null,
        public readonly ?string $last_logout = null,
        public readonly ?int $logins = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            online: (bool) ($data->online ?? false),
            last_login: $data->last_login ?? null,
            last_logout: $data->last_logout ?? null,
            logins: $data->logins ?? null,
        );
    }
}
