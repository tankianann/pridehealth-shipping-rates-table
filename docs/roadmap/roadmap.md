# Project Master Roadmap

**Last updated:** 2026-09-10

## Project Outcome

Deliver a maintainable WordPress plugin that gives authorized WooCommerce administrators an accurate, read-only overview of live shipping rates and dependable Markdown sharing tools.

## Status Guide

- **Planned** — anticipated but not started.
- **In progress** — currently being worked on.
- **Implemented** — deliverables exist; required verification or review remains.
- **Complete** — implementation, verification, required review, and documentation are finished.
- **Deferred** — intentionally postponed.
- **Cancelled** — deliberately removed from the plan.

## Milestone Overview

| Milestone | Status | Intended outcome | Remaining work or dependency |
| --- | --- | --- | --- |
| [1. Source migration and project definition](../milestones/01-source-migration.md) | Complete | Establish the reference plugin as documented source under `app/src`. | None. |
| [2. Baseline compatibility and behavior verification](../milestones/02-baseline-verification.md) | Planned | Demonstrate the imported plugin's behavior and compatibility in a representative WooCommerce environment. | Select the supported-version matrix and test environment. |
| 3. Release readiness and handoff | Planned | Resolve verified release blockers and prepare an approved release candidate. | Depends on Milestone 2 findings and an explicit packaging request. |

## Completed Milestones

Milestone 1 imported the version 1.1.0 PHP implementation without behavioral changes, established `app/src` as the source of truth, and replaced neutral workspace documentation with project-specific guidance.

## Active Milestone

No implementation milestone is currently active. [Milestone 2](../milestones/02-baseline-verification.md) is fully outlined and is the next planned milestone once the test matrix and environment are selected.

## Upcoming Milestones

Milestone 2 will establish repeatable static and runtime evidence for the current plugin. Milestone 3 will respond to those findings, complete release-readiness review, and package a distribution only if explicitly requested.

## Dependencies and Decision Points

- Runtime verification requires access to a WordPress installation with WooCommerce and representative shipping zones.
- The supported WordPress, PHP, and WooCommerce version matrix has not yet been selected.
- Structural refactoring should be driven by verification or an agreed feature need rather than performed speculatively.

## Deferred and Post-Project Work

- Distribution ZIP creation is deferred until explicitly requested.
- New features, user-interface redesign, and broader reporting are outside the current plan until requirements are supplied.

## Immediate Next Step

Select the Milestone 2 compatibility matrix and a WordPress/WooCommerce environment for runtime verification.
