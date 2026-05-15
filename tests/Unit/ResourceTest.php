<?php

use Seatplus\EsiSchema\Contracts\EsiRawResponse;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Alliance\GetAlliancesAllianceId;
use Seatplus\EsiSchema\Resources\Assets\GetCharactersCharacterIdAssets;
use Seatplus\EsiSchema\Resources\Assets\GetCorporationsCorporationIdAssets;
use Seatplus\EsiSchema\Resources\FreelanceJobs\GetFreelanceJobsListing;
use Seatplus\EsiSchema\Responses\AllianceDetail;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAssetsGetItem;

// ---------------------------------------------------------------------------
// Helper
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

        public function assertScope(?string $scope): void
        {
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

it('GetAlliancesAllianceId::execute returns typed DTO', function (): void {
    $payload = (object) [
        'name'                   => 'Goonswarm Federation',
        'ticker'                 => 'CONDI',
        'creator_id'             => 1,
        'creator_corporation_id' => 2,
        'date_founded'           => '2006-12-26T00:00:00Z',
        'executor_corporation_id' => 3,
        'faction_id'             => null,
        'member_count'           => 42000,
    ];

    $dto = GetAlliancesAllianceId::execute(mockTransport($payload), 99000006);

    expect($dto)->toBeInstanceOf(AllianceDetail::class)
        ->and($dto->name)->toBe('Goonswarm Federation')
        ->and($dto->ticker)->toBe('CONDI')
        ->and($dto->isCachedLoad)->toBeFalse()
        ->and($dto->pages)->toBe(1);
});

it('DTO isCachedLoad is propagated from transport response', function (): void {
    $payload = (object) [
        'name'                   => 'Test Alliance',
        'ticker'                 => 'TEST',
        'creator_id'             => 1,
        'creator_corporation_id' => 2,
        'date_founded'           => '2010-01-01T00:00:00Z',
    ];

    $dto = GetAlliancesAllianceId::execute(mockTransport($payload, isCachedLoad: true, pages: 2), 12345);

    expect($dto->isCachedLoad)->toBeTrue()
        ->and($dto->pages)->toBe(2);
});

// ---------------------------------------------------------------------------
// Array endpoint — returns EsiResult
// ---------------------------------------------------------------------------

it('GetCharactersCharacterIdAssets::execute returns EsiResult with typed array', function (): void {
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

    $result = GetCharactersCharacterIdAssets::execute(mockTransport($payload, pages: 3), 12345);

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
// Meta — typed constants on Operation classes
// ---------------------------------------------------------------------------

it('GetCharactersCharacterIdAssets meta constants are correct', function (): void {
    expect(GetCharactersCharacterIdAssets::CACHE_AGE)->toBe(3600)
        ->and(GetCharactersCharacterIdAssets::REQUIRED_ROLES)->toBeEmpty()
        ->and(GetCharactersCharacterIdAssets::USES_CURSOR)->toBeFalse()
        ->and(GetCharactersCharacterIdAssets::RATE_LIMIT_GROUP)->toBe('char-asset')
        ->and(GetCharactersCharacterIdAssets::RATE_LIMIT_MAX_TOKENS)->toBe(1800)
        ->and(GetCharactersCharacterIdAssets::REQUIRED_SCOPE)->toBe('esi-assets.read_assets.v1');
});

it('GetCorporationsCorporationIdAssets meta includes Director role', function (): void {
    expect(GetCorporationsCorporationIdAssets::RATE_LIMIT_GROUP)->toBe('corp-asset')
        ->and(GetCorporationsCorporationIdAssets::REQUIRED_ROLES)->toBe(['Director'])
        ->and(GetCorporationsCorporationIdAssets::REQUIRED_SCOPE)->toBe('esi-assets.read_corporation_assets.v1');
});

it('GetFreelanceJobsListing marks cursor-paginated endpoint', function (): void {
    expect(GetFreelanceJobsListing::USES_CURSOR)->toBeTrue();
});
