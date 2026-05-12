<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2025-12-16).
 * Do not edit manually — run bin/generate.php instead.
 */
final class RouteRequestBody extends AbstractEsiDto
{
    public function __construct(
        public readonly ?array $avoid_systems = null,
        public readonly ?array $connections = null,
        public readonly ?string $preference = null,
        public readonly ?int $security_penalty = null,
    ) {}

    public static function from(object $data): static
    {
        return new static(
            avoid_systems: isset($data->avoid_systems) ? (array) $data->avoid_systems : null,
            connections: isset($data->connections) ? (array) $data->connections : null,
            preference: $data->preference ?? null,
            security_penalty: $data->security_penalty ?? null,
        );
    }
}