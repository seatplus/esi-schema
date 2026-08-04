<?php

use Seatplus\EsiSchema\Contracts\EsiRawResponse;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\Resources\Alliance\GetAlliancesAllianceId;
use Seatplus\EsiSchema\Resources\Assets\GetCharactersCharacterIdAssets;
use Seatplus\EsiSchema\Resources\Assets\GetCorporationsCorporationIdAssets;
use Seatplus\EsiSchema\Resources\Character\PostCharactersCharacterIdCspa;
use Seatplus\EsiSchema\Resources\Fleets\PostFleetsFleetIdWings;
use Seatplus\EsiSchema\Resources\FreelanceJobs\GetFreelanceJobsListing;
use Seatplus\EsiSchema\Resources\Skills\GetCharactersCharacterIdSkillqueue;
use Seatplus\EsiSchema\Responses\AllianceDetail;
use Seatplus\EsiSchema\Responses\CharactersCharacterIdAssetsGetItem;
use Seatplus\EsiSchema\Responses\CharactersSkillqueueSkill;
use Seatplus\EsiSchema\Responses\FleetsFleetIdWingsPost;

// ---------------------------------------------------------------------------
// Helper
// ---------------------------------------------------------------------------

function mockTransport(mixed $data, bool $isCachedLoad = false, int $pages = 1, ?int $rateLimitRemaining = null): EsiTransportInterface
{
    return new class ($data, $isCachedLoad, $pages, $rateLimitRemaining) implements EsiTransportInterface {
        public function __construct(
            private readonly mixed $data,
            private readonly bool $isCachedLoad,
            private readonly int $pages,
            private readonly ?int $rateLimitRemaining,
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
                rateLimitRemaining: $this->rateLimitRemaining,
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

/**
 * Issue #81. The skill queue is the one endpoint in the document that declares its
 * body inline instead of behind a component $ref, so it was the one endpoint whose
 * payload the generator dropped — silently, because `EsiResult<null>` reads as a
 * correct annotation for the 20 endpoints that really do return nothing.
 *
 * It is also the only operation that reaches the generator's array-of-$ref emitter,
 * so this is the only runtime coverage that branch has.
 */
it('GetCharactersCharacterIdSkillqueue::execute maps its inline array body', function (): void {
    $payload = [
        (object) [
            'finished_level'    => 5,
            'queue_position'    => 0,
            'skill_id'          => 3300,
            'finish_date'       => '2026-08-05T12:00:00Z',
            'level_end_sp'      => 256000,
            'level_start_sp'    => 45255,
            'start_date'        => '2026-08-04T12:00:00Z',
            'training_start_sp' => 50000,
        ],
        (object) [
            'finished_level' => 3,
            'queue_position' => 1,
            'skill_id'       => 3301,
        ],
    ];

    $result = GetCharactersCharacterIdSkillqueue::execute(mockTransport($payload, pages: 1), 12345);

    expect($result)->toBeInstanceOf(EsiResult::class)
        ->and($result->data)->toBeArray()->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(CharactersSkillqueueSkill::class)
        ->and($result->data[0]->skill_id)->toBe(3300)
        ->and($result->data[0]->finished_level)->toBe(5)
        ->and($result->data[0]->finish_date)->toBe('2026-08-05T12:00:00Z')
        ->and($result->data[1])->toBeInstanceOf(CharactersSkillqueueSkill::class)
        ->and($result->data[1]->queue_position)->toBe(1)
        ->and($result->data[1]->finish_date)->toBeNull();
});

/**
 * The other seven operations #81 repaired declare their body under 201 rather than
 * 200, which the generator also discarded. The payload is the id of the thing just
 * created, so without it the endpoint cannot be chained — a new wing's id is a
 * required argument to the call that adds a squad to it.
 */
it('PostFleetsFleetIdWings::execute returns the created wing id', function (): void {
    $dto = PostFleetsFleetIdWings::execute(mockTransport((object) ['wing_id' => 2000000001]), 99);

    expect($dto)->toBeInstanceOf(FleetsFleetIdWingsPost::class)
        ->and($dto->wing_id)->toBe(2000000001);
});

it('PostCharactersCharacterIdCspa::execute returns the cost as a float', function (): void {
    $result = PostCharactersCharacterIdCspa::execute(mockTransport(2950.5), (object) ['characters' => [1]], 12345);

    expect($result)->toBeInstanceOf(EsiResult::class)
        ->and($result->data)->toBe(2950.5);
});

it('EsiResult::fromRaw carries isCachedLoad', function (): void {
    $raw    = new EsiRawResponse(data: [], isCachedLoad: true, pages: 5);
    $result = EsiResult::fromRaw($raw, []);

    expect($result->isCachedLoad)->toBeTrue()
        ->and($result->pages)->toBe(5);
});

it('EsiResult::fromRaw carries rateLimitRemaining', function (): void {
    $raw    = new EsiRawResponse(data: [], rateLimitRemaining: 750);
    $result = EsiResult::fromRaw($raw, []);

    expect($result->rateLimitRemaining)->toBe(750);
});

it('EsiResult rateLimitRemaining defaults to null', function (): void {
    $result = new EsiResult(data: []);

    expect($result->rateLimitRemaining)->toBeNull();
});

it('rateLimitRemaining is propagated for array endpoints', function (): void {
    $payload = [
        (object) ['item_id' => 1, 'type_id' => 35, 'location_id' => 60003760, 'location_type' => 'station', 'location_flag' => 'Hangar', 'is_singleton' => false, 'quantity' => 1],
    ];
    $result = GetCharactersCharacterIdAssets::execute(
        mockTransport($payload, rateLimitRemaining: 1200),
        12345
    );

    expect($result->rateLimitRemaining)->toBe(1200);
});

it('rateLimitRemaining is propagated for single-object DTO endpoints', function (): void {
    $payload = (object) [
        'name' => 'Test Alliance',
        'ticker' => 'TEST',
        'creator_id' => 1,
        'creator_corporation_id' => 2,
        'date_founded' => '2010-01-01T00:00:00Z',
    ];
    $dto = GetAlliancesAllianceId::execute(
        mockTransport($payload, rateLimitRemaining: 500),
        99000001
    );

    expect($dto->rateLimitRemaining)->toBe(500);
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
