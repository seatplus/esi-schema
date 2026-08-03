#!/usr/bin/env php
<?php

/**
 * Compute the next semver tag from the current one and a bump level.
 *
 * Usage:
 *   php bin/next-version.php --current=2.0.0 --bump=major   # -> 3.0.0
 *
 * Exists as a script rather than inline shell so that both esi-sync.yml (which
 * predicts the version for a report) and release.yml (which computes it
 * authoritatively at tag time) use one implementation and cannot disagree.
 *
 * A bump of `none` is an error: callers must decide not to release before they
 * get here, rather than tagging the same version twice.
 */

declare(strict_types=1);

$args = [];
foreach (array_slice($_SERVER['argv'] ?? [], 1) as $arg) {
    if (str_starts_with($arg, '--')) {
        [$k, $v] = explode('=', ltrim($arg, '-'), 2) + [1 => 'true'];
        $args[$k] = $v;
    }
}

$current = $args['current'] ?? null;
$bump    = $args['bump'] ?? null;

if ($current === null || $bump === null) {
    fwrite(STDERR, "usage: php bin/next-version.php --current=<x.y.z> --bump=major|minor|patch\n");
    exit(1);
}

if (preg_match('/^(\d+)\.(\d+)\.(\d+)$/', $current, $m) !== 1) {
    fwrite(STDERR, "FATAL: --current='{$current}' is not a bare x.y.z version.\n");
    exit(1);
}

[, $major, $minor, $patch] = array_map(intval(...), $m);

$next = match ($bump) {
    'major' => ($major + 1) . '.0.0',
    'minor' => $major . '.' . ($minor + 1) . '.0',
    'patch' => $major . '.' . $minor . '.' . ($patch + 1),
    default => null,
};

if ($next === null) {
    fwrite(STDERR, "FATAL: --bump='{$bump}' must be major, minor or patch.\n");
    if ($bump === 'none') {
        fwrite(STDERR, "A bump of 'none' means there is nothing to release — do not tag.\n");
    }
    exit(1);
}

echo $next, "\n";
