<?php

use Seatplus\EsiSchema\Contracts\EsiOperationInterface;
use Seatplus\EsiSchema\Contracts\EsiRawResponse;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;
use Seatplus\EsiSchema\EsiResult;
use Seatplus\EsiSchema\GeneratedSpec;
use Seatplus\EsiSchema\OperationMeta;
use Seatplus\EsiSchema\Resources\Assets\GetCharactersCharacterIdAssets;
use Seatplus\EsiSchema\Resources\Assets\GetCorporationsCorporationIdAssets;
use Seatplus\EsiSchema\Resources\Market\GetMarketsPrices;

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
        ->and($meta->cacheAge)->toBe(3600)
        ->and($meta->rateLimitGroup)->toBe('char-asset')
        ->and($meta->rateLimitMaxTokens)->toBe(1800)
        ->and($meta->requiredScope)->toBe('esi-assets.read_assets.v1')
        ->and($meta->requiredRoles)->toBeEmpty()
        ->and($meta->usesCursor)->toBeFalse();
});

it('GetCorporationsCorporationIdAssets::meta returns director role requirement', function (): void {
    $meta = GetCorporationsCorporationIdAssets::meta();

    expect($meta->requiredRoles)->toBe(['Director'])
        ->and($meta->requiredScope)->toBe('esi-assets.read_corporation_assets.v1')
        ->and($meta->rateLimitGroup)->toBe('corp-asset');
});

it('GetMarketsPrices::meta returns null scope for public endpoint', function (): void {
    $meta = GetMarketsPrices::meta();

    expect($meta->requiredScope)->toBeNull()
        ->and($meta->requiredRoles)->toBeEmpty();
});

// ---------------------------------------------------------------------------
// HTTP method casing (issue #83)
// ---------------------------------------------------------------------------

/**
 * RFC 9110 §9.1: method tokens are case-sensitive and every registered method is
 * uppercase, so 'get' and 'GET' are different methods on the wire. Guzzle 8.0 stops
 * silently uppercasing, at which point a lowercase verb is a wire-level defect.
 *
 * The mocks above only see the handful of endpoints they exercise, and the surface
 * manifest never records method bodies — so a regression in bin/generate.php would
 * be invisible to both the test suite and bin/api-diff.php. This reads every
 * generated call site instead.
 */
it('every generated Resource invokes the transport with an uppercase HTTP method', function (): void {
    $files = glob(dirname(__DIR__, 2) . '/src/Resources/*/*.php') ?: [];
    $verbs = [];

    foreach ($files as $file) {
        $source = (string) file_get_contents($file);
        preg_match_all("/transport->invoke\('([^']+)'/", $source, $matches);

        foreach ($matches[1] as $verb) {
            $verbs[] = $verb;
        }
    }

    // A failed glob or a renamed emitter would otherwise let this pass vacuously.
    // One invoke() per route class, so the count is exactly the generated route count.
    expect($verbs)->toHaveCount(GeneratedSpec::ROUTE_COUNT);

    foreach ($verbs as $verb) {
        expect($verb)->toBeIn(['GET', 'POST', 'PUT', 'DELETE']);
    }
});

// ---------------------------------------------------------------------------
// execute() calls transport correctly and returns EsiResult
// ---------------------------------------------------------------------------

it('GetCharactersCharacterIdAssets::execute returns EsiResult with typed items', function (): void {
    $transport = new class () implements EsiTransportInterface {
        public function assertScope(?string $scope): void
        {
        }

        public function invoke(string $method, string $path, array $pathValues = [], array $queryParams = [], array $requestBody = []): EsiRawResponse
        {
            expect($method)->toBe('GET')
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
        ->and($result->data)->toHaveCount(1);
});

it('GetCharactersCharacterIdAssets::execute passes page parameter', function (): void {
    $transport = new class () implements EsiTransportInterface {
        public function assertScope(?string $scope): void
        {
        }

        public function invoke(string $method, string $path, array $pathValues = [], array $queryParams = [], array $requestBody = []): EsiRawResponse
        {
            expect($queryParams['page'])->toBe(3);

            return new EsiRawResponse(data: [], isCachedLoad: false, pages: 3);
        }
    };

    $result = GetCharactersCharacterIdAssets::execute($transport, 42, 3);

    expect($result->pages)->toBe(3);
});
