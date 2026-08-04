#!/usr/bin/env bash
#
# Independent second opinion on "did anything get removed?".
#
# bin/api-diff.php is ~500 lines of hand-rolled classification, and it is the one
# component whose bugs publish breaking changes as minors — a Packagist tag cannot
# be withdrawn. This script answers the same question by a completely different
# route: grepping the working-tree diff for disappearing public members.
#
# It works because bin/generate.php emits exactly one public member per line, so a
# removed class, property, constant or method is a '-' line matching a fixed shape.
# Verified against the real 2026-05-19 -> 2026-07-21 transition: nine hits, zero
# false positives.
#
# It is deliberately NOT a replacement for the classifier. It cannot see a newly
# added *required* parameter (a '+' line with no '-'), and it cannot rank severity.
# Its only job is to disagree: if the classifier says "nothing was removed" and
# this says otherwise, the pipeline must escalate to a human rather than release.
#
# Usage:  removal-crosscheck.sh [<git-diff-args>...]
# Output: the removed member lines, one per line, on stdout.
# Exit:   0 if removals were found, 1 if none.

set -euo pipefail

cd "$(git rev-parse --show-toplevel)"

# src/GeneratedSpec.php is excluded, and this exclusion is load-bearing rather than
# cosmetic. Its constants (COMPATIBILITY_DATE, SPEC_SHA256, the counts) change on
# every regeneration, so a '-' line for them appears every single time. Because
# GeneratedSpec is deliberately absent from .esi/surface.json, the classifier never
# counts those as breaking — so on a date-only sync the classifier reports 0
# breaking while this script reported "removals found", which esi-sync reads as the
# two disagreeing and escalates to a human.
#
# That would have made every date-only sync escalate and never auto-release, which
# is precisely the path the pipeline exists to automate. Verified before fixing:
# changing only the date in GeneratedSpec produced `exit 0` here against `bump:
# none, breaking: 0` from the classifier.
#
# The rule to keep in mind: this script must only ever look at the same surface the
# classifier looks at, or "they disagree" stops meaning anything.
readonly SCOPE=(src ':!src/GeneratedSpec.php')

# Deleted files are removals that never show up as '-' member lines.
deleted_files="$(git diff --name-status "$@" -- "${SCOPE[@]}" | awk '$1 == "D" { print "deleted file: " $2 }')"

# Removed public members. Metadata constants are excluded: their *values* are
# CCP-side data and change harmlessly, which would otherwise drown the signal.
removed_members="$(
  git diff -U0 "$@" -- "${SCOPE[@]}" \
    | grep '^-' \
    | grep -vE '^---' \
    | grep -E 'public function|public readonly|public const' \
    | grep -vE 'CACHE_AGE|RATE_LIMIT_GROUP|RATE_LIMIT_MAX_TOKENS|RATE_LIMIT_WINDOW|USES_CURSOR' \
    | sed 's/^-[[:space:]]*/removed: /' \
    || true
)"

output="$(printf '%s\n%s\n' "$deleted_files" "$removed_members" | grep -v '^$' || true)"

if [ -z "$output" ]; then
  exit 1
fi

printf '%s\n' "$output"
