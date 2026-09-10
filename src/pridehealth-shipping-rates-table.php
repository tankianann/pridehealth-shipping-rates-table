<?php
/**
 * Plugin Name: PrideHealth Shipping Rates Table
 * Description: Displays configured WooCommerce shipping zones and methods in a read-only admin table.
 * Version: 1.1.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Requires Plugins: woocommerce
 * Author: Kian Ann, OpenAI GPT-5.6 Sol (Co Author)
 * License: GPL-2.0-or-later
 * Text Domain: pridehealth-shipping-rates-table
 */

defined( 'ABSPATH' ) || exit;

final class PrideHealth_Shipping_Rates_Table {
	private const PAGE_SLUG = 'pridehealth-shipping-rates-table';
	private const EXPORT_ACTION = 'pridehealth_shipping_rates_export_markdown';

	public static function init(): void {
		add_action( 'admin_menu', array( __CLASS__, 'register_admin_page' ), 99 );
		add_action( 'admin_notices', array( __CLASS__, 'maybe_show_dependency_notice' ) );
		add_action( 'admin_post_' . self::EXPORT_ACTION, array( __CLASS__, 'export_markdown' ) );
	}

	public static function register_admin_page(): void {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		add_submenu_page(
			'woocommerce',
			__( 'Shipping Rates Table', 'pridehealth-shipping-rates-table' ),
			__( 'Shipping Rates Table', 'pridehealth-shipping-rates-table' ),
			'manage_woocommerce',
			self::PAGE_SLUG,
			array( __CLASS__, 'render_admin_page' )
		);
	}

	public static function maybe_show_dependency_notice(): void {
		if ( class_exists( 'WooCommerce' ) || ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		echo '<div class="notice notice-error"><p>';
		echo esc_html__( 'PrideHealth Shipping Rates Table requires WooCommerce to be installed and active.', 'pridehealth-shipping-rates-table' );
		echo '</p></div>';
	}

	public static function render_admin_page(): void {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_die( esc_html__( 'You do not have permission to view this page.', 'pridehealth-shipping-rates-table' ) );
		}

		if ( ! class_exists( 'WC_Shipping_Zones' ) ) {
			wp_die( esc_html__( 'WooCommerce shipping zones are unavailable.', 'pridehealth-shipping-rates-table' ) );
		}

		$rows            = self::get_rate_rows();
		$region_rowspans = array();

		foreach ( $rows as $row ) {
			$region_rowspans[ $row['group'] ] = ( $region_rowspans[ $row['group'] ] ?? 0 ) + 1;
		}

		$trello_markdown = self::build_markdown_list( $rows );
		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'Shipping Rates Table', 'pridehealth-shipping-rates-table' ); ?></h1>
			<p>
				<?php echo esc_html__( 'This read-only table is generated from your current WooCommerce shipping zones and methods.', 'pridehealth-shipping-rates-table' ); ?>
			</p>
			<p>
				<button
					type="button"
					class="button button-primary"
					id="wc-srt-copy-trello"
					data-copied-label="<?php echo esc_attr__( 'Copied!', 'pridehealth-shipping-rates-table' ); ?>"
				>
					<?php echo esc_html__( 'Copy for Trello', 'pridehealth-shipping-rates-table' ); ?>
				</button>
				<a class="button button-primary" href="<?php echo esc_url( self::get_export_url( 'table' ) ); ?>">
					<?php echo esc_html__( 'Export Markdown Table', 'pridehealth-shipping-rates-table' ); ?>
				</a>
				<a class="button" href="<?php echo esc_url( self::get_export_url( 'list' ) ); ?>">
					<?php echo esc_html__( 'Export Markdown List', 'pridehealth-shipping-rates-table' ); ?>
				</a>
				<span class="wc-srt-copy-status" id="wc-srt-copy-status" aria-live="polite"></span>
			</p>

			<details class="wc-srt-preview">
				<summary><?php echo esc_html__( 'Preview Trello-ready Markdown', 'pridehealth-shipping-rates-table' ); ?></summary>
				<textarea id="wc-srt-trello-markdown" class="large-text code" rows="12" readonly><?php echo esc_textarea( $trello_markdown ); ?></textarea>
			</details>

			<table class="widefat striped wc-shipping-rates-table">
				<thead>
					<tr>
						<th scope="col"><?php echo esc_html__( 'Region(s)', 'pridehealth-shipping-rates-table' ); ?></th>
						<th scope="col"><?php echo esc_html__( 'Shipping method', 'pridehealth-shipping-rates-table' ); ?></th>
						<th scope="col"><?php echo esc_html__( 'Configured rate', 'pridehealth-shipping-rates-table' ); ?></th>
						<th scope="col"><?php echo esc_html__( 'Status', 'pridehealth-shipping-rates-table' ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php if ( empty( $rows ) ) : ?>
					<tr>
						<td colspan="4"><?php echo esc_html__( 'No shipping methods were found.', 'pridehealth-shipping-rates-table' ); ?></td>
					</tr>
				<?php else : ?>
					<?php $rendered_groups = array(); ?>
					<?php foreach ( $rows as $row ) : ?>
						<tr>
							<?php if ( ! isset( $rendered_groups[ $row['group'] ] ) ) : ?>
								<th class="wc-srt-region" scope="rowgroup" rowspan="<?php echo esc_attr( (string) $region_rowspans[ $row['group'] ] ); ?>">
									<?php echo esc_html( $row['regions'] ); ?>
								</th>
								<?php $rendered_groups[ $row['group'] ] = true; ?>
							<?php endif; ?>
							<td><?php echo esc_html( $row['method'] ); ?></td>
							<td><?php echo wp_kses_post( $row['rate'] ); ?></td>
							<td>
								<span class="wc-srt-status wc-srt-status--<?php echo $row['enabled'] ? 'enabled' : 'disabled'; ?>">
									<?php echo esc_html( $row['enabled'] ? __( 'Enabled', 'pridehealth-shipping-rates-table' ) : __( 'Disabled', 'pridehealth-shipping-rates-table' ) ); ?>
								</span>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
		</div>

		<style>
			.wc-shipping-rates-table { margin-top: 18px; }
			.wc-shipping-rates-table th { font-weight: 600; }
			.wc-shipping-rates-table td { vertical-align: middle; }
			.wc-shipping-rates-table .wc-srt-region { width: 28%; vertical-align: middle; }
			.wc-srt-status { display: inline-block; padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; }
			.wc-srt-status--enabled { color: #135e2b; background: #edfaef; }
			.wc-srt-status--disabled { color: #646970; background: #f0f0f1; }
			.wc-srt-preview { max-width: 900px; margin: 12px 0 18px; }
			.wc-srt-preview summary { cursor: pointer; font-weight: 600; }
			.wc-srt-preview textarea { margin-top: 10px; }
			.wc-srt-copy-status { margin-left: 8px; font-weight: 600; color: #135e2b; }
		</style>

		<script>
			(function () {
				'use strict';

				var button = document.getElementById('wc-srt-copy-trello');
				var source = document.getElementById('wc-srt-trello-markdown');
				var status = document.getElementById('wc-srt-copy-status');

				if (!button || !source) {
					return;
				}

				function fallbackCopy(text) {
					var temporary = document.createElement('textarea');
					temporary.value = text;
					temporary.setAttribute('readonly', '');
					temporary.style.position = 'fixed';
					temporary.style.left = '-9999px';
					document.body.appendChild(temporary);
					temporary.select();
					document.execCommand('copy');
					document.body.removeChild(temporary);
				}

				button.addEventListener('click', function () {
					var copyPromise = navigator.clipboard && window.isSecureContext
						? navigator.clipboard.writeText(source.value)
						: Promise.resolve().then(function () { fallbackCopy(source.value); });

					copyPromise.then(function () {
						status.textContent = button.getAttribute('data-copied-label');
						window.setTimeout(function () { status.textContent = ''; }, 2000);
					}).catch(function () {
						fallbackCopy(source.value);
						status.textContent = button.getAttribute('data-copied-label');
						window.setTimeout(function () { status.textContent = ''; }, 2000);
					});
				});
			}());
		</script>
		<?php
	}

	private static function get_export_url( string $format ): string {
		return wp_nonce_url(
			add_query_arg(
				array(
					'action' => self::EXPORT_ACTION,
					'format' => $format,
				),
				admin_url( 'admin-post.php' )
			),
			self::EXPORT_ACTION
		);
	}

	public static function export_markdown(): void {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_die( esc_html__( 'You do not have permission to export shipping rates.', 'pridehealth-shipping-rates-table' ) );
		}

		check_admin_referer( self::EXPORT_ACTION );

		if ( ! class_exists( 'WC_Shipping_Zones' ) ) {
			wp_die( esc_html__( 'WooCommerce shipping zones are unavailable.', 'pridehealth-shipping-rates-table' ) );
		}

		$rows   = self::get_rate_rows();
		$format = isset( $_GET['format'] ) ? sanitize_key( wp_unslash( $_GET['format'] ) ) : 'table';
		$format = 'list' === $format ? 'list' : 'table';

		if ( 'list' === $format ) {
			$markdown = self::build_markdown_list( $rows );
		} else {
			$markdown  = "# Shipping Rates\n\n";
			$markdown .= sprintf(
				"Generated from %s on %s.\n\n",
				self::escape_markdown_cell( get_bloginfo( 'name' ) ),
				wp_date( 'Y-m-d H:i T' )
			);
			$markdown .= self::build_markdown_table( $rows );
		}

		$filename = 'pridehealth-shipping-rates-' . $format . '-' . wp_date( 'Y-m-d' ) . '.md';

		nocache_headers();
		header( 'Content-Type: text/markdown; charset=' . get_bloginfo( 'charset' ) );
		header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
		header( 'Content-Length: ' . strlen( $markdown ) );

		echo $markdown; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Plain-text file download.
		exit;
	}

	private static function build_markdown_table( array $rows ): string {
		$markdown  = "| Region(s) | Shipping method | Configured rate | Status |\n";
		$markdown .= "|---|---|---:|---|\n";

		foreach ( $rows as $row ) {
			$markdown .= sprintf(
				"| %s | %s | %s | %s |\n",
				self::escape_markdown_cell( $row['regions'] ),
				self::escape_markdown_cell( $row['method'] ),
				self::escape_markdown_cell( self::get_plain_rate( $row ) ),
				$row['enabled'] ? 'Enabled' : 'Disabled'
			);
		}

		return $markdown;
	}

	private static function build_markdown_list( array $rows ): string {
		$markdown     = '';
		$current_group = null;

		foreach ( $rows as $row ) {
			if ( $current_group !== $row['group'] ) {
				if ( null !== $current_group ) {
					$markdown .= "\n";
				}
				$markdown .= sprintf( "**%s**\n", self::escape_markdown_text( $row['zone'] ) );
				$current_group = $row['group'];
			}

			$status = $row['enabled'] ? '' : ' (Disabled)';
			$markdown .= sprintf(
				"- %s: %s%s\n",
				self::escape_markdown_text( $row['method'] ),
				self::escape_markdown_text( self::get_plain_rate( $row ) ),
				$status
			);
		}

		return $markdown;
	}

	private static function get_plain_rate( array $row ): string {
		return html_entity_decode(
			wp_strip_all_tags( $row['rate'] ),
			ENT_QUOTES | ENT_HTML5,
			get_bloginfo( 'charset' ) ?: 'UTF-8'
		);
	}

	private static function escape_markdown_cell( string $value ): string {
		$value = str_replace( array( "\r\n", "\r", "\n" ), ' ', $value );
		return str_replace( array( '\\', '|' ), array( '\\\\', '\\|' ), trim( $value ) );
	}

	private static function escape_markdown_text( string $value ): string {
		$value = str_replace( array( "\r\n", "\r", "\n" ), ' ', trim( $value ) );
		return preg_replace( '/([\\\\`*_{}\[\]<>#+.!|])/u', '\\\\$1', $value ) ?? '';
	}

	/**
	 * Build one display row for every configured shipping method.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	private static function get_rate_rows(): array {
		$rows  = array();
		$zones = WC_Shipping_Zones::get_shipping_zones();

		// Zone 0 is WooCommerce's "Locations not covered by your other zones" zone.
		$rest_of_world = WC_Shipping_Zones::get_zone( 0 );
		if ( $rest_of_world instanceof WC_Shipping_Zone ) {
			$zones[] = $rest_of_world;
		}

		foreach ( $zones as $zone ) {
			if ( ! $zone instanceof WC_Shipping_Zone ) {
				continue;
			}

			$regions = $zone->get_formatted_location();
			if ( '' === trim( wp_strip_all_tags( $regions ) ) ) {
				$regions = __( 'All other locations', 'pridehealth-shipping-rates-table' );
			}

			foreach ( $zone->get_shipping_methods( false, 'admin' ) as $method ) {
				$rows[] = array(
					'group'   => 'zone-' . $zone->get_id(),
					'zone'    => $zone->get_id()
						? $zone->get_zone_name()
						: __( 'Locations not covered by your other zones', 'pridehealth-shipping-rates-table' ),
					'regions' => wp_strip_all_tags( $regions ),
					'method'  => $method->get_title(),
					'rate'    => self::format_method_rate( $method ),
					'enabled' => 'yes' === $method->enabled,
				);
			}
		}

		return $rows;
	}

	private static function format_method_rate( WC_Shipping_Method $method ): string {
		if ( 'free_shipping' === $method->id ) {
			return esc_html__( 'Free', 'pridehealth-shipping-rates-table' )
				. ' ('
				. esc_html__( 'Condition', 'pridehealth-shipping-rates-table' )
				. ': '
				. self::format_free_shipping_condition( $method )
				. ')';
		}

		$cost = $method->get_option( 'cost', '' );

		if ( is_numeric( $cost ) ) {
			return wc_price( (float) $cost );
		}

		if ( is_string( $cost ) && '' !== trim( $cost ) ) {
			return '<code>' . esc_html( $cost ) . '</code>';
		}

		return esc_html__( 'Not specified', 'pridehealth-shipping-rates-table' );
	}

	private static function format_free_shipping_condition( WC_Shipping_Method $method ): string {
		if ( 'free_shipping' !== $method->id ) {
			return '';
		}

		$requirement = $method->get_option( 'requires', '' );
		$minimum     = $method->get_option( 'min_amount', '0' );
		$before_discounts = 'yes' === $method->get_option( 'ignore_discounts', 'no' );
		$minimum_label = sprintf(
			/* translators: %s: formatted minimum order amount. */
			$before_discounts
				? __( 'Minimum order amount before discounts: %s', 'pridehealth-shipping-rates-table' )
				: __( 'Minimum order amount: %s', 'pridehealth-shipping-rates-table' ),
			wc_price( is_numeric( $minimum ) ? (float) $minimum : 0 )
		);

		switch ( $requirement ) {
			case 'min_amount':
				return $minimum_label;
			case 'coupon':
				return esc_html__( 'A valid free shipping coupon', 'pridehealth-shipping-rates-table' );
			case 'either':
				return sprintf(
					/* translators: %s: minimum order amount requirement. */
					__( '%s or a valid free shipping coupon', 'pridehealth-shipping-rates-table' ),
					$minimum_label
				);
			case 'both':
				return sprintf(
					/* translators: %s: minimum order amount requirement. */
					__( '%s and a valid free shipping coupon', 'pridehealth-shipping-rates-table' ),
					$minimum_label
				);
			default:
				return esc_html__( 'No requirement', 'pridehealth-shipping-rates-table' );
		}
	}
}

PrideHealth_Shipping_Rates_Table::init();
