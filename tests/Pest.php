<?php

uses(\PHPUnit\Framework\TestCase::class)->in('tests');

// Make pest-plugin-type-coverage analyse in one process. Its forked workers each
// read-modify-write one shared cache file under a lock that gives up and writes
// anyway, corrupting it into invalid PHP on every cold run at this repo's 536
// generated files — and the plugin then include()s it, so the breakage sticks.
// Has to live here, not as an env var on the composer script: $_ENV is only
// populated from the environment when variables_order contains E, and the php.ini
// files PHP ships use GPCS.
$_ENV['__PEST_PLUGIN_ENV'] = '1';
