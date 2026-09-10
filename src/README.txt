=== PrideHealth Shipping Rates Table ===
Requires at least: 6.0
Requires PHP: 7.4
Requires Plugins: woocommerce
Stable tag: 1.1.0
License: GPL-2.0-or-later

Adds a read-only WooCommerce admin page listing every configured shipping zone and shipping method, with Markdown export and Trello-ready copy tools.

== Description ==

PrideHealth Shipping Rates Table reads the current WooCommerce shipping configuration and presents it in one administration table.

Features:

* Lists configured shipping zones, regions, methods, rates, and enabled states.
* Shows Free Shipping requirements alongside the rate.
* Formats simple numeric costs using the store currency settings.
* Preserves configured flat-rate formulas whose final value depends on the cart.
* Exports the current data as a Markdown table or Markdown list.
* Copies a clean, region-grouped list for Trello.

No shipping rates are hard-coded or modified by this plugin.

== Installation ==

1. Upload the plugin directory or its ZIP through Plugins > Add New Plugin > Upload Plugin.
2. Activate PrideHealth Shipping Rates Table.
3. Open WooCommerce > Shipping Rates Table.

Direct admin URL:

`/wp-admin/admin.php?page=pridehealth-shipping-rates-table`

== Frequently Asked Questions ==

= Does the plugin change shipping settings? =

No. The page is read-only and retrieves the current WooCommerce configuration.

= Are disabled methods shown? =

Yes. Disabled methods remain visible and are marked Disabled.

= How are formula-based costs displayed? =

They are shown as configured because the final value depends on the customer's cart.

== Changelog ==

= 1.1.0 =

* Imported the existing plugin as the documented project baseline.
