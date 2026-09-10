# Distribution Verification: 1.1.0

**Date:** 2026-09-10
**Result:** Packaging checks passed; runtime verification pending

## Artifact

- Path: `dist/pridehealth-shipping-rates-table-1.1.0.zip`
- SHA-256: `3e7d434991538f1b07306cf2ac539e514eab30cc25a6f0b55031d65202c884eb`

## Archive Manifest

```text
pridehealth-shipping-rates-table/
pridehealth-shipping-rates-table/pridehealth-shipping-rates-table.php
pridehealth-shipping-rates-table/README.txt
```

## Checks

- `unzip -t` reported no compressed-data errors.
- The PHP header and README stable tag both identify version 1.1.0.
- The packaged PHP file has the same SHA-256 digest as `app/src/pridehealth-shipping-rates-table.php`: `9c6577e2938328c35b3dbe216179b9408905498ce6b7e46e1f87b6d221f53d4c`.
- `php -l app/src/pridehealth-shipping-rates-table.php` reports no syntax errors.
- The archive excludes `.DS_Store`, Git metadata, and project-only documentation.

## Review Boundary

These checks validate the package structure and source integrity. They do not validate the plugin inside WordPress or WooCommerce. The archive should not be treated as a fully verified release until the compatibility and behavior work in Milestone 2 is complete.
