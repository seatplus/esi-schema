# CLAUDE.md — seatplus/esi-schema

Guidance for Claude Code working in this package on its own (e.g. opened as a
standalone Orca project). A standalone checkout does **not** inherit the core
app's `CLAUDE.md`, skills, or MCP — this file is the local pointer.

## What this is
**esi-schema** — a code-generated PHP library wrapping the EVE Online ESI
(Swagger/OpenAPI) API: one static class per ESI endpoint (typed constants,
`meta()`, `execute()`), typed response DTOs, **zero runtime dependencies**. Its
generated operation classes are what `eveapi`'s queue jobs reference as
`OPERATION_CLASS` (endpoint metadata: `REQUIRED_SCOPE`, `RATE_LIMIT_*`,
`CACHE_AGE`, …). It's part of the seatplus stack that feeds
`esi-client → eveapi → auth → web`.

## Read these first (authoritative, already in this repo)
- **`ARCHITECTURE.md`** — the design decisions (one static class per endpoint, etc.).
- **`.github/copilot-instructions.md`** — detailed repo guide, including the
  **code-generation** flow. Most of `src/Resources/` and `src/Responses/` is
  **generated — do not hand-edit; regenerate.**

The wider project (other packages, domain rules, shared `.claude/skills/`) lives
in **[seatplus/core](https://github.com/seatplus/core)**, whose `CLAUDE.md` is the
source of truth. laravel-boost, the browser MCP, and frontend work apply only
there, not here.

## Testing
No database or Redis needed.

```bash
composer run test        # Pint + PHPStan + 100% type-coverage + Pest
```

Local Pest runs use Test Impact Analysis: tests your change cannot have affected
are replayed from a cached dependency graph rather than executed. It only engages
when a coverage driver (pcov / Xdebug) is present, and CI always runs everything.
Use `vendor/bin/pest --no-tia` when you want a full local run — for example
before claiming the suite is green.
