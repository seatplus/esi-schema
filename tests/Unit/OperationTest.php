<?php

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiRawResponse;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Operations\GetCharactersCharacterIdAssets;
use Seatplus\EsiSchema\Operations\GetCorporationsCorporationIdAssets;
use Seatplus\EsiSchema\Operations\GetMarketsPrices;

// ---------------------------------------------------------------------------
// EsiOperationInterface contract
// ---------------------------------------------------------------------------

it('GetCharactersCharacterIdAssets implements EsiOperationInterface', function (): void {
    expect(GetCharactersCharacterIdAssets::class)
        ->toImplement(EsiOperationInterface::class);
});

it('GetMarketsPrices implements EsiOperationInterface', function (): void {
    expect(GetMarketsPrices::class)
        ->toImplement(EsiOperationInterface::class);
});

// ---------------------------------------------------------------------------
// meta() returns correct OperationMeta
// ---------------------------------------------------------------------------

it('GetCharactersCharacterIdAssets::meta returns correct metadata', function (): void {
    $meta = GetCharactersCharacterIdAssets::meta();

    expect($meta)->toBeInstanceOf(OperationMeta::class)
        ->and($meta->cacheAge())->toBe(3600)
        ->and($meta->rateLimitGroup())->toBe('char-asset')
        ->and($meta->rateLimitMaxTokens())->toBe(1800)
        ->and($meta->requiredScope())->toBe('esi-assets.read_assets.v1')
        ->and($meta->requiredRoles())->toBeEmpty()
        ->and($meta->usesCursor())->toBeFalse();
});

it('GetCorporationsCorporationIdAssets::meta returns director role requirement', function (): void {
    $meta = GetCorporationsCorporationIdAssets::meta();

    expect($meta->requiredRoles())->toBe(['Director'])
        ->and($meta->requiredScope())->toBe('esi-assets.read_corporation_assets.v1')
        ->and($meta->rateLimitGroup())->toBe('corp-asset');
});

it('GetMarketsPrices::meta returns null scope for public endpoint', function (): void {
    $meta = GetMarketsPrices::meta();

    expect($meta->requiredScope())->toBeNull()
        ->and($meta->requiredRoles())->toBeEmpty();
});

// ---------------------------------------------------------------------------
// tokenSatisfies() via operation meta
// ---------------------------------------------------------------------------

it('operation meta tokenSatisfies returns true when scope is present', function (): void {
    $scopes = ['esi-assets.read_assets.v1', 'esi-wallet.read_character_wallet.v1'];

    expect(GetCharactersCharacterIdAssets::meta()->tokenSatisfies($scopes))->toBeTrue();
});

it('operation meta tokenSatisfies returns false when scope is missing', function (): void {
    expect(GetCharactersCharacterIdAssets::meta()->tokenSatisfies(['esi-wallet.read_character_wallet.v1']))
        ->toBeFalse();
});

it('public operation meta tokenSatisfies always returns true', function (): void {
    expect(GetMarketsPrices::meta()->tokenSatisfies([]))->toBeTrue();
});

// ---------------------------------------------------------------------------
// execute() calls transport correctly and returns EsiResult
// ---------------------------------------------------------------------------

it('GetCharactersCharacterIdAssets::execute returns EsiResult with typed items', function (): void {
    $transport = new class implements EsiTransportInterface {
        public function invoke(string $method, string $path, array $pathValues = [], array $queryParams = [], array $requestBody = []): EsiRawResponse
        {
            expect($method)->toBe('get')
                ->and($path)->toBe('/characters/{character_id}/assets')
                ->and($pathValues)->toBe(['character_id' => 42])
                ->and($queryParams)->toBe(['page' => 1]);

            return new EsiRawResponse(
                data: [(object) ['item_id' => 100, 'location_id' => 60003760, 'location_type' => 'station', 'location_flag' => 'Hangar', 'type_id' => 35, 'quantity' => 1, 'is_singleton' => false]],
                isCachedLoad: false,
                pages: 1,
            );
        }
    };

    $result = GetCharactersCharacterIdAssets::execute($transport, 42);

    expect($result)->toBeInstanceOf(EsiResult::class)
        ->and($result->isCachedLoad)->toBeFalse()
        ->and($result->data)->toHaveCount(1)
        ->and($result->requiredScope())->toBe('esi-assets.read_assets.v1')
        ->and($result->rateLimitGroup())->toBe('char-asset');
});

it('GetCharactersCharacterIdAssets::execute passes page parameter', function (): void {
    $transport = new class implements EsiTransportInterface {
        public function invoke(string $method, string $path, array $pathValues = [], array $queryParams = [], array $requestBody = []): EsiRawResponse
        {
            expect($queryParams['page'])->toBe(3);

            return new EsiRawResponse(data: [], isCachedLoad: false, pages: 3);
        }
    };

    $result = GetCharactersCharacterIdAssets::execute($transport, 42, 3);

    expect($result->pages)->toBe(3);
});
