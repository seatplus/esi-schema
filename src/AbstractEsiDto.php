<?php

namespace Seatplus\EsiSchema;

use Seatplus\EsiSchema\Concerns\HasOperationMeta;

/**
 * Base class for all generated ESI response DTOs.
 *
 * HTTP metadata is stored here as regular (mutable) properties so that
 * resource methods can set them after calling ::from().
 * The child readonly classes keep their own data properties immutable.
 */
abstract class AbstractEsiDto
{
    use HasOperationMeta;

    /** True when the response was served from the RFC 7234 cache (HTTP 304). */
    public bool $isCachedLoad = false;

    /** Total pages reported by X-Pages header. 1 for non-paginated endpoints. */
    public int $pages = 1;

    /** ESI spec metadata from the operation class. */
    public ?OperationMeta $operationMeta = null;
}
