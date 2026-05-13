<?php

namespace Seatplus\EsiSchema;

/**
 * Base class for all generated ESI response DTOs.
 *
 * HTTP metadata is stored here as regular (mutable) properties so that
 * resource methods can set them after calling ::from().
 * The child readonly classes keep their own data properties immutable.
 *
 * For operation metadata (requiredScope, cacheAge, etc.) access the
 * Operation class directly: GetCharactersCharacterIdAssets::meta()
 */
abstract class AbstractEsiDto
{
    /** True when the response was served from the RFC 7234 cache (HTTP 304). */
    public bool $isCachedLoad = false;

    /** Total pages reported by X-Pages header. 1 for non-paginated endpoints. */
    public int $pages = 1;
}
