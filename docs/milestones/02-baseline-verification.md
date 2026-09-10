# Milestone 2: Baseline Compatibility and Behavior Verification

**Status:** Planned

## Outcome

Produce evidence that the imported plugin behaves as documented on a supported WordPress and WooCommerce installation, and identify any changes needed before release use.

## Scope

- Define a proportionate supported-version test matrix.
- Add repeatable static checks appropriate for WordPress PHP.
- Verify dependency handling, access control, table rendering, rate formatting, clipboard output, and both export formats in a test installation.
- Record findings and resolve release-blocking defects.

## Constraints

- Preserve read-only behavior toward WooCommerce shipping configuration.
- Do not create or modify a release ZIP without explicit authorization.
- Avoid architectural refactoring unless verification evidence justifies it.

## Acceptance Criteria

- Supported environments and test procedure are documented.
- Required static checks pass.
- Critical administrator and export paths are exercised with representative shipping-zone configurations.
- Security-sensitive capability and nonce behavior are verified.
- Results and any accepted limitations are recorded under `docs/reviews/`.

## Verification

- Run the documented static checks.
- Execute the behavior matrix in the selected WordPress/WooCommerce environment.
- Review recorded evidence against every acceptance criterion.
