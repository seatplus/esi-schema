<?php

declare(strict_types=1);

namespace Seatplus\EsiSchema;

use Seatplus\EsiSchema\Concerns\HasOperationMeta;
use Seatplus\EsiSchema\Contracts\EsiRawResponse;

/**
 * Typed wrapper returned by resource methods for array / paginated endpoints.
 *
 * Single-object endpoints return the DTO directly (the DTO itself carries
 * $isCachedLoad and $pages via AbstractEsiDto).
 *
 * @template T
 */
readonly class EsiResult
{
    use HasOperationMeta;

    /**
     * @param  T                $data         Typed response body (array of DTOs or primitives).
     * @param  int              $pages        Total pages reported by X-Pages (1 when not paginated).
     * @param  bool             $isCachedLoad Whether the response was served from RFC 7234 cache.
     * @param  ?OperationMeta   $operationMeta ESI spec metadata from the operation class.
     */
    public function __construct(
        public mixed $data,
        public int $pages = 1,
        public bool $isCachedLoad = false,
        public ?OperationMeta $operationMeta = null,
    ) {
    }

    /**
     * Build an EsiResult from a raw transport response and already-typed data.
     *
     * @template TData
     *
     * @param  TData            $typedData
     * @param  ?OperationMeta   $meta       OperationMeta from the calling Operation class.
     * @return EsiResult<TData>
     */
    public static function fromRaw(EsiRawResponse $response, mixed $typedData, ?OperationMeta $meta = null): self
    {
        return new self(
            data: $typedData,
            pages: $response->pages,
            isCachedLoad: $response->isCachedLoad,
            operationMeta: $meta,
        );
    }
}
