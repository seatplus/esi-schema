<?php

declare(strict_types=1);

use Seatplus\EsiSchema\Contracts\EsiRawResponse;
use Seatplus\EsiSchema\Contracts\EsiTransportInterface;

// ---------------------------------------------------------------------------
// Discover all operation classes (subdirectories of src/Resources/).
// Resource wrapper classes (e.g. AssetsResource.php) live directly in
// src/Resources/ and have no execute() — they are excluded.
// ---------------------------------------------------------------------------

function allOperationClasses(): array
{
    $resourceDir = dirname(__DIR__, 2) . '/src/Resources';
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($resourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
    );

    $classes = [];
    foreach ($iterator as $file) {
        if (! $file->isFile() || $file->getExtension() !== 'php') {
            continue;
        }

        // Only files one level deeper (i.e. in a tag subdirectory, not directly in Resources/)
        if ($file->getPath() === $resourceDir) {
            continue;
        }

        $relative = substr($file->getPathname(), strlen($resourceDir) + 1, -4); // e.g. "Assets/GetCharacters..."
        $classes[] = 'Seatplus\\EsiSchema\\Resources\\' . str_replace('/', '\\', $relative);
    }

    sort($classes);

    return $classes;
}

// ---------------------------------------------------------------------------
// Build a spy transport that captures the scope passed to assertScope().
// ---------------------------------------------------------------------------

function makeSpy(string &$capturedScope): EsiTransportInterface
{
    $capture = function (string $scope) use (&$capturedScope): void {
        $capturedScope = $scope;
    };

    return new class ($capture) implements EsiTransportInterface {
        /** @param Closure(string): void $capture */
        public function __construct(private Closure $capture)
        {
        }

        public function assertScope(?string $scope): void
        {
            ($this->capture)($scope ?? '__null__');
        }

        public function invoke(string $method, string $path, array $pathValues = [], array $queryParams = [], array $requestBody = []): EsiRawResponse
        {
            return new EsiRawResponse(data: [], isCachedLoad: false, pages: 1);
        }
    };
}

// ---------------------------------------------------------------------------
// Build a default argument list for execute() via reflection.
// assertScope() is always the first line, so we only need type-safe values
// for the required typed parameters.
// ---------------------------------------------------------------------------

function buildArgs(string $class, EsiTransportInterface $transport): array
{
    $params = array_slice(
        (new ReflectionMethod($class, 'execute'))->getParameters(),
        1, // skip $transport
    );

    $args = [$transport];
    foreach ($params as $param) {
        if ($param->isOptional()) {
            break;
        }
        /** @var ReflectionNamedType|null $type */
        $type = $param->getType() instanceof ReflectionNamedType ? $param->getType() : null;
        $args[] = match ($type?->getName()) {
            'int'    => 0,
            'string' => '',
            'float'  => 0.0,
            'bool'   => false,
            'array'  => [],
            default  => null,
        };
    }

    return $args;
}

// ---------------------------------------------------------------------------
// The test: assert that every operation calls assertScope(REQUIRED_SCOPE).
// ---------------------------------------------------------------------------

it('every operation calls assertScope with its declared REQUIRED_SCOPE', function (string $class): void {
    $capturedScope = '__not_called__';
    $transport = makeSpy($capturedScope);
    $args = buildArgs($class, $transport);

    $class::execute(...$args);

    $expectedScope = defined("{$class}::REQUIRED_SCOPE") ? constant("{$class}::REQUIRED_SCOPE") : null;
    $expectedLabel = $expectedScope ?? '__null__';

    expect($capturedScope)
        ->not->toBe('__not_called__', "assertScope() was never called in {$class}")
        ->toBe($expectedLabel, "assertScope() called with wrong scope in {$class}");
})->with(allOperationClasses());

// ---------------------------------------------------------------------------
// Sanity: the dataset must include all 208 generated operations.
// ---------------------------------------------------------------------------

it('operation class dataset covers at least 200 classes', function (): void {
    expect(count(allOperationClasses()))->toBeGreaterThanOrEqual(200);
});
