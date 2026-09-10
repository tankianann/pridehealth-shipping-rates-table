# Milestone 1: Source Migration and Project Definition

**Status:** Complete
**Completed:** 2026-09-10

## Outcome

Establish the supplied PrideHealth Shipping Rates Table plugin as an independently versioned application source tree with enough documentation to guide future work.

## Scope

- Create the single-application `app/src` root.
- Copy the plugin PHP entry point and plugin README from the read-only reference.
- Exclude operating-system metadata from application source.
- Document purpose, users, behavior, requirements, source provenance, repository structure, and the anticipated delivery path.
- Verify source placement, PHP syntax, documentation links, and preservation of the reference implementation.

## Constraints

- Do not edit or delete the reference directory.
- Do not alter plugin behavior during migration.
- Do not create a distribution archive.

## Acceptance Criteria

- `app/src/pridehealth-shipping-rates-table.php` matches the supplied PHP implementation byte-for-byte.
- `app/src/README.txt` accurately describes version 1.1.0, its requirements, installation, and behavior.
- Machine metadata such as `.DS_Store` is absent from `app/src`.
- Project overview, roadmap, current status, and source-layout decision are present and mutually consistent.
- The migrated PHP file passes a syntax check.
- `/reference` remains unchanged.

## Verification

- Compare SHA-256 hashes of the reference and migrated PHP files.
- Run `php -l app/src/pridehealth-shipping-rates-table.php`.
- Inspect the final Git diff and confirm only `/app` changed.

The completed results are recorded in [`../reviews/01-source-migration-verification.md`](../reviews/01-source-migration-verification.md).
