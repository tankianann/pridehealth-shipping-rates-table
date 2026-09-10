# Project Overview

## Product

PrideHealth Shipping Rates Table is a single-application WordPress plugin for WooCommerce. It provides a consolidated, read-only view of configured shipping zones and methods in the WordPress administration area.

## Users and Outcome

The primary users are WooCommerce administrators who need to review or share the store's shipping configuration without opening each zone individually. Success means an authorized administrator can see the live configuration accurately and export or copy it in a useful Markdown format without changing WooCommerce data.

## Current Behavior

- Registers **WooCommerce → Shipping Rates Table** for users with the `manage_woocommerce` capability.
- Lists shipping regions, methods, configured rates, and enabled states, including the catch-all zone.
- Displays Free Shipping requirements and store-formatted numeric prices.
- Leaves formula-based flat-rate costs in their configured form.
- Exports Markdown table and list files through a nonce-protected administrator action.
- Provides a Trello-ready Markdown list with an in-page preview and clipboard control.
- Shows an administration notice when WooCommerce is unavailable.

## Technical Baseline

- WordPress 6.0 or later.
- PHP 7.4 or later.
- WooCommerce is a required plugin dependency.
- The plugin currently uses one self-contained PHP entry point with inline administration CSS and JavaScript.
- The source application root is `app/src`.

## Scope and Constraints

The plugin is observational: it must not modify shipping configuration. Administrative access and export actions must remain capability-checked, and export requests must remain protected against cross-site request forgery. A distribution ZIP is outside the normal source workflow and is not created unless explicitly requested.

## Source Provenance

The initial version 1.1.0 implementation was supplied in `/reference/pridehealth-shipping-rates-table` and imported into `app/src` on 2026-09-10 at the user's direction. The reference directory remains unchanged and read-only; `app/src` is now the project source of truth.

## Open Questions

- Which WordPress and WooCommerce versions must be included in the compatibility matrix beyond the declared minimums?
- Should the next delivery preserve the single-file architecture or separate presentation assets and domain logic for testability?
- What release and deployment process should be used when a distributable package is requested?
