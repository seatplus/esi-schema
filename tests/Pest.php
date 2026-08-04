<?php

uses(\PHPUnit\Framework\TestCase::class)->in('tests');

// Run pest-plugin-type-coverage's PHPStan pass in a single process instead of
// forking pokio workers.
//
// Each worker calls Cache::persist() once per analysed file, and every call
// read-modify-writes one shared `vendor/pestphp/pest-plugin-type-coverage/.temp/
// v3.php`. The advisory lock around that write gives up after 100 attempts of
// 1ms and then writes anyway, so with enough concurrent writers the var_export
// payloads splice into each other. The result is invalid PHP that the plugin
// `include`s on the next run — one bad run wedges every later run until the file
// is deleted by hand.
//
// Concurrency scales with core count (one worker per core here, 12 on this
// machine), and `src` is code-generated at 536 files, so there are far more
// writers and far more writes than in the sibling packages — eveapi is 169 files.
// Cold runs corrupted 3/3 with forking on, and still 3/3 with FORK_IO_FACTOR=1,
// so trimming concurrency is not enough. Size is the most likely difference, but
// it is not proven: the siblings have not been run against this file count.
//
// Setting `$_ENV['__PEST_PLUGIN_ENV']` is what avoids it. Note this is an
// UNDOCUMENTED internal check, not a supported knob — Analyser.php is the only
// thing in the tree that reads it (two sites, zero writes), so a minor plugin
// release could drop it. Of the two sites, the one that does the real work is the
// `$maxProcesses = 1` branch: that leaves a single chunk and therefore a single
// writer, so no interleaving is possible. The other site merely skips
// `pokio()->useFork()`. If this ever regresses it fails loudly with a ParseError
// rather than silently passing.
//
// It is set here in PHP rather than as an env var on the composer script for two
// reasons: `$_ENV` is only populated from the environment when `variables_order`
// contains `E` (php.ini-development ships `GPCS`, which would make an env prefix
// silently do nothing), and doing it here also covers a bare
// `vendor/bin/pest --type-coverage`, which would otherwise corrupt the cache for
// every subsequent run.
//
// Load order is guaranteed, not luck: Kernel::boot() runs the BootFiles
// bootstrapper (which includes this file) before Kernel::handle() reaches the
// plugin, and both reads happen in the parent process before any fork.
$_ENV['__PEST_PLUGIN_ENV'] = '1';

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
