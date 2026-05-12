<?php

use Seatplus\EsiSchema\Contracts\EsiRawResponse;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\AllianceResource;
use Seatplus\EsiSchema\Resources\AssetsResource;
use Seatplus\EsiSchema\Responses\AllianceDetail;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAssetsGetItem;

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------

function mockTransport(mixed $data, bool $isCachedLoad = false, int $pages = 1): EsiTransportInterface
{
    return new class ($data, $isCachedLoad, $pages) implements EsiTransportInterface {
        public function __construct(
            private readonly mixed $data,
            private readonly bool $isCachedLoad,
            private readonly int $pages,
        ) {
        }

        public function invoke(
            string $method,
            string $path,
            array $pathValues = [],
            array $queryParams = [],
            array $requestBody = [],
        ): EsiRawResponse {
            return new EsiRawResponse(
                data: $this->data,
                isCachedLoad: $this->isCachedLoad,
                pages: $this->pages,
            );
        }
    };
}

// ---------------------------------------------------------------------------
// EsiTransportInterface contract
// ---------------------------------------------------------------------------

it('EsiRawResponse carries data, isCachedLoad, pages', function (): void {
    $raw = new EsiRawResponse(data: (object) ['name' => 'Test'], isCachedLoad: true, pages: 3);

    expect($raw->data)->toBeObject()
        ->and($raw->isCachedLoad)->toBeTrue()
        ->and($raw->pages)->toBe(3);
});

// ---------------------------------------------------------------------------
// Object endpoint — returns DTO directly
// ---------------------------------------------------------------------------

it('AllianceResource::getAlliancesAllianceId returns typed DTO', function (): void {
    $payload = (object) [
        'name'            => 'Goonswarm Federation',
        'ticker'          => 'CONDI',
        'creator_id'      => 1,
        'creator_corporation_id' => 2,
        'date_founded'    => '2006-12-26T00:00:00Z',
        'executor_corporation_id' => 3,
        'faction_id'      => null,
        'member_count'    => 42000,
    ];

    $resource = new AllianceResource(mockTransport($payload));
    $dto = $resource->getAlliancesAllianceId(99000006);

    expect($dto)->toBeInstanceOf(AllianceDetail::class)
        ->and($dto->name)->toBe('Goonswarm Federation')
        ->and($dto->ticker)->toBe('CONDI')
        ->and($dto->isCachedLoad)->toBeFalse()
        ->and($dto->pages)->toBe(1);
});

it('DTO isCachedLoad is propagated from transport response', function (): void {
    $payload = (object) [
        'name'            => 'Test Alliance',
        'ticker'          => 'TEST',
        'creator_id'      => 1,
        'creator_corporation_id' => 2,
        'date_founded'    => '2010-01-01T00:00:00Z',
    ];

    $resource = new AllianceResource(mockTransport($payload, isCachedLoad: true, pages: 2));
    $dto = $resource->getAlliancesAllianceId(12345);

    expect($dto->isCachedLoad)->toBeTrue()
        ->and($dto->pages)->toBe(2);
});

// ---------------------------------------------------------------------------
// Array endpoint — returns EsiResult
// ---------------------------------------------------------------------------

it('AssetsResource::getCharactersCharacterIdAssets returns EsiResult with typed array', function (): void {
    $payload = [
        (object) [
            'item_id'       => 1001,
            'location_id'   => 60003760,
            'location_flag' => 'Hangar',
            'location_type' => 'station',
            'type_id'       => 35,
            'quantity'      => 100,
            'is_singleton'  => false,
        ],
    ];

    $resource = new AssetsResource(mockTransport($payload, pages: 3));
    $result = $resource->getCharactersCharacterIdAssets(12345);

    expect($result)->toBeInstanceOf(EsiResult::class)
        ->and($result->pages)->toBe(3)
        ->and($result->data)->toBeArray()->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(CharactersCharacterIdAssetsGetItem::class)
        ->and($result->data[0]->item_id)->toBe(1001);
});

it('EsiResult::fromRaw carries isCachedLoad', function (): void {
    $raw    = new EsiRawResponse(data: [], isCachedLoad: true, pages: 5);
    $result = EsiResult::fromRaw($raw, []);

    expect($result->isCachedLoad)->toBeTrue()
        ->and($result->pages)->toBe(5);
});

// ---------------------------------------------------------------------------
// OPERATION_META / metaFor()
// ---------------------------------------------------------------------------

it('AssetsResource::metaFor returns correct metadata for char endpoint', function (): void {
    $meta = AssetsResource::metaFor('getCharactersCharacterIdAssets');

    expect($meta['cacheAge'])->toBe(3600)
        ->and($meta['requiredRoles'])->toBeEmpty()
        ->and($meta['cursor'])->toBeFalse()
        ->and($meta['rateLimit'])->toMatchArray(['group' => 'char-asset', 'max-tokens' => 1800]);
});

it('AssetsResource::metaFor returns corp rate-limit group and required Director role', function (): void {
    $meta = AssetsResource::metaFor('getCorporationsCorporationIdAssets');

    expect($meta['rateLimit']['group'])->toBe('corp-asset')
        ->and($meta['requiredRoles'])->toBe(['Director']);
});

it('metaFor returns safe defaults for unknown operationId', function (): void {
    $meta = AssetsResource::metaFor('doesNotExist');

    expect($meta['cacheAge'])->toBeNull()
        ->and($meta['rateLimit'])->toBeNull()
        ->and($meta['requiredRoles'])->toBeEmpty()
        ->and($meta['cursor'])->toBeFalse();
});

it('FreelanceJobsResource::metaFor marks cursor endpoints correctly', function (): void {
    $meta = \Seatplus\EsiSchema\Resources\FreelanceJobsResource::metaFor('getFreelanceJobsListing');

    expect($meta['cursor'])->toBeTrue();
});

// ---------------------------------------------------------------------------
// Result-level metadata accessors (injected at call time from OPERATION_META)
// ---------------------------------------------------------------------------

it('EsiResult carries rate-limit metadata from char assets call', function (): void {
    $payload = [
        (object) [
            'item_id'       => 1001,
            'location_id'   => 60003760,
            'location_flag' => 'Hangar',
            'location_type' => 'station',
            'type_id'       => 35,
            'quantity'      => 100,
            'is_singleton'  => false,
        ],
    ];

    $resource = new AssetsResource(mockTransport($payload));
    $result   = $resource->getCharactersCharacterIdAssets(12345);

    expect($result->rateLimitGroup())->toBe('char-asset')
        ->and($result->rateLimitMaxTokens())->toBe(1800)
        ->and($result->rateLimitWindow())->toBe('15m')
        ->and($result->cacheAge())->toBe(3600)
        ->and($result->requiredRoles())->toBeEmpty()
        ->and($result->usesCursor())->toBeFalse()
        ->and($result->requiredScope())->toBe('esi-assets.read_assets.v1');
});

it('EsiResult carries different rate-limit group for corp assets call', function (): void {
    $resource = new AssetsResource(mockTransport([]));
    $result   = $resource->getCorporationsCorporationIdAssets(98000001);

    expect($result->rateLimitGroup())->toBe('corp-asset')
        ->and($result->requiredRoles())->toBe(['Director'])
        ->and($result->requiredScope())->toBe('esi-assets.read_corporation_assets.v1');
});

it('DTO carries metadata from object endpoint call', function (): void {
    $payload = (object) [
        'name'                   => 'Goonswarm Federation',
        'ticker'                 => 'CONDI',
        'creator_id'             => 1,
        'creator_corporation_id' => 2,
        'date_founded'           => '2006-12-26T00:00:00Z',
    ];

    $resource = new \Seatplus\EsiSchema\Resources\AllianceResource(mockTransport($payload));
    $dto      = $resource->getAlliancesAllianceId(99000006);

    expect($dto->rateLimitGroup())->toBeNull()  // alliance endpoint has no rate-limit in spec
        ->and($dto->cacheAge())->toBeGreaterThan(0)
        ->and($dto->requiredRoles())->toBeEmpty()
        ->and($dto->requiredScope())->toBeNull();  // public endpoint — no auth required
});

it('EsiResult meta accessors return null/false when no meta is set', function (): void {
    $raw    = new EsiRawResponse(data: [], isCachedLoad: false, pages: 1);
    $result = EsiResult::fromRaw($raw, []);  // no meta passed

    expect($result->rateLimitGroup())->toBeNull()
        ->and($result->rateLimitMaxTokens())->toBeNull()
        ->and($result->rateLimitWindow())->toBeNull()
        ->and($result->cacheAge())->toBeNull()
        ->and($result->requiredRoles())->toBeEmpty()
        ->and($result->usesCursor())->toBeFalse()
        ->and($result->requiredScope())->toBeNull();
});
