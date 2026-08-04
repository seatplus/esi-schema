<?php

uses(\PHPUnit\Framework\TestCase::class)->in('tests');

// Test Impact Analysis: replay unaffected tests from a cached dependency graph
// instead of re-running them. Enabled for developers only — a release gate must
// execute every test, never trust a cache.
//
// The `getenv('CI')` guard is what actually keeps CI out. Pest's own local/CI
// split (and therefore `->locally()`) is set by the explicit `--ci` flag alone,
// not by the environment, and `composer test` has no way to pass that flag to
// the `test:unit` step. `->locally()` is kept as a second signal so that
// `pest --ci` also opts out.
//
// Today CI is safe regardless, because TIA needs pcov or Xdebug to record which
// source files a test touches and .github/actions/verify installs PHP with
// `coverage: none` — without a driver TIA degrades to a full run. That is a
// coincidence of the current CI config, not a guarantee; this guard is what
// survives someone enabling a coverage driver there.
//
// Escape hatches: `--no-tia` for one run, `--tia --fresh` to rebuild the graph.
if (getenv('CI') === false) {
    pest()->tia()->locally();
}
