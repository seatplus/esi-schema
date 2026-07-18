<?php

namespace Seatplus\EsiSchema\Responses;

use Seatplus\EsiSchema\AbstractEsiDto;

/**
 * Generated from ESI OpenAPI spec (compatibility date: 2026-07-17).
 * Do not edit manually — run bin/generate.php instead.
 */
final class SovereigntySystemsSovereigntyhub extends AbstractEsiDto
{
    public function __construct(
        public readonly int $id,
        public readonly ?SovereigntySystemsVulnerabilitywindow $vulnerability_window = null,
    ) {
    }

    public static function from(object $data): static
    {
        return new static(
            id: (int) ($data->id ?? 0),
            vulnerability_window: isset($data->vulnerability_window) ? SovereigntySystemsVulnerabilitywindow::from($data->vulnerability_window) : null,
        );
    }
}
