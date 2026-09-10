# Decision 0001: Use `app/src` as the Plugin Root

**Status:** Accepted
**Date:** 2026-09-10

## Context

The project contains one independently installed application: a WordPress plugin. The supplied reference implementation consists of a PHP plugin entry point and a distributable README.

## Decision

Use `app/src` as both the application source root and the plugin package root. Place `pridehealth-shipping-rates-table.php` and `README.txt` directly inside it so the directory can be linked into a local WordPress plugin directory or packaged without an extra nesting level.

Keep project documentation, intake material, reviews, and future project-level tooling outside `src`. Treat `/reference/pridehealth-shipping-rates-table` as immutable provenance rather than an editable source tree.

## Consequences

- Product changes are made only in `app/src`.
- The original reference remains available for comparison.
- A future release archive, when explicitly requested, should package the contents of `src` under a `pridehealth-shipping-rates-table/` directory.
- Project-level tests or tooling may be added alongside `src` when the verification milestone defines them.
