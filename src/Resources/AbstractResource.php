<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema\Resources;

use Seatplus\EsiSchema\Contracts\EsiTransportInterface;

/**
 * Base class for all generated ESI resource classes.
 *
 * Generated from ESI OpenAPI spec — do not edit manually.
 * Run bin/generate.php to regenerate.
 */
abstract class AbstractResource
{
    public function __construct(
        protected readonly EsiTransportInterface $transport,
    ) {
    }
}
