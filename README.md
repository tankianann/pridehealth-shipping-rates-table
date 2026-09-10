# PrideHealth Shipping Rates Table

PrideHealth Shipping Rates Table is a small WordPress plugin that adds a read-only WooCommerce administration page for reviewing every configured shipping zone and method in one place.

The table reports each method's configured rate and enabled state. Administrators can export the current configuration as a Markdown table or list, or copy a region-grouped list for Trello.

## Requirements

- WordPress 6.0 or later
- PHP 7.4 or later
- WooCommerce installed and active

## Project Structure

- `src/` — installable WordPress plugin source.
- `docs/overview/` — project purpose, users, behavior, scope, and constraints.
- `docs/roadmap/` — current status and anticipated delivery milestones.
- `docs/milestones/` — detailed milestone definitions and completion records.
- `docs/decisions/` — durable implementation and repository decisions.
- `inbox/` — intake and provenance for future project material.

The original plugin supplied in `/reference/pridehealth-shipping-rates-table` is read-only reference material. All future product changes belong in `app/src`.

## Installation

For local development, copy or link `src/` into a WordPress installation at `wp-content/plugins/pridehealth-shipping-rates-table`, then activate **PrideHealth Shipping Rates Table** in WordPress.

The production-style upload flow expects a ZIP whose root contains the files from `src/`. Distribution archives are created only when explicitly requested.

After activation, open **WooCommerce → Shipping Rates Table**, or visit:

```text
/wp-admin/admin.php?page=pridehealth-shipping-rates-table
```

## Documentation

- [Project overview](docs/overview/project.md)
- [Current status](docs/roadmap/current-status.md)
- [Master roadmap](docs/roadmap/roadmap.md)
- [Source layout decision](docs/decisions/0001-source-layout.md)

## Distribution

The current versioned archive is [`dist/pridehealth-shipping-rates-table-1.1.0.zip`](dist/pridehealth-shipping-rates-table-1.1.0.zip).

SHA-256:

```text
3e7d434991538f1b07306cf2ac539e514eab30cc25a6f0b55031d65202c884eb
```

The archive has passed structure, compression-integrity, source-integrity, and PHP syntax checks. Runtime compatibility and behavior verification in WordPress and WooCommerce remain pending.
