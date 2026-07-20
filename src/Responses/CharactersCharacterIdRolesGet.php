<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class CharactersCharacterIdRolesGet extends AbstractEsiDto
{
    public function __construct(
        public readonly ?array $roles = null,
        public readonly ?array $roles_at_base = null,
        public readonly ?array $roles_at_hq = null,
        public readonly ?array $roles_at_other = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            roles: isset($data->roles) ? (array) $data->roles : null,
            roles_at_base: isset($data->roles_at_base) ? (array) $data->roles_at_base : null,
            roles_at_hq: isset($data->roles_at_hq) ? (array) $data->roles_at_hq : null,
            roles_at_other: isset($data->roles_at_other) ? (array) $data->roles_at_other : null,
        );
    }
}
