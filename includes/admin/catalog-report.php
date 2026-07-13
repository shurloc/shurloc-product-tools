<?php
/**
 * Catalog report admin tools.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', 'shurloc_handle_product_tools_request' );

/**
 * Register the Shur-Loc Product Tools page.
 */
add_action(
	'admin_menu',
	function () {

		add_management_page(
			'Shur-Loc Product Tools',
			'Shur-Loc Product Tools',
			'manage_options',
			'shurloc-product-tools',
			'shurloc_render_product_tools_page'
		);
	}
);

/**
 * Render the Product Tools page.
 */
function shurloc_render_product_tools_page(): void {
	?>

	<div class="wrap">

		<h1>Shur-Loc Product Tools</h1>

		<p>
			Utilities for exporting and analyzing the WooCommerce product catalog.
		</p>

		<hr>

		<h2>Export Catalog Variations</h2>

		<p>
			Export WooCommerce variation names as a JSON file for parser
			development and testing.
		</p>

		<form method="post">

			<?php wp_nonce_field( 'shurloc_export_variations' ); ?>

			<input
				type="hidden"
				name="shurloc_action"
				value="export_variations"
			/>

			<?php submit_button( 'Export Variations', 'primary', 'submit', false ); ?>

		</form>

		<hr>

		<h2>Generate Catalog Report</h2>

		<p>
			Analyze the WooCommerce catalog using the mesh parser and download
			a JSON report containing recognized, unrecognized, and invalid
			specifications.
		</p>

		<form method="post">

			<?php wp_nonce_field( 'shurloc_generate_catalog_report' ); ?>

			<input
				type="hidden"
				name="shurloc_action"
				value="generate_catalog_report"
			/>

			<?php submit_button( 'Generate Catalog Report', 'secondary', 'submit', false ); ?>

		</form>

	</div>

	<?php
}

/**
 * Export WooCommerce catalog variations.
 */
function shurloc_export_variations(): void {

	// Verify permissions.
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die(
			esc_html__(
				'You do not have permission to perform this action.',
				'shurloc-product-tools'
			)
		);
	}

	shurloc_download_json(
		'shurloc-variations.json',
		shurloc_get_catalog_variations()
	);
}

/**
 * Generate a catalog analysis report.
 */
function shurloc_generate_catalog_report(): void {

	// Verify permissions.
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die(
			esc_html__(
				'You do not have permission to perform this action.',
				'shurloc-product-tools'
			)
		);
	}

	$entries = shurloc_get_catalog_entries();

	$parser = new Shurloc_Mesh_Parser();

	$analyzer = new Shurloc_Catalog_Analyzer(
		$parser
	);

	$report = $analyzer->analyze(
		$entries
	);

	shurloc_download_json(
		'catalog-report.json',
		$report->to_array()
	);
}

/**
 * Handle tool requests.
 */
function shurloc_handle_product_tools_request(): void {

	if ( ! isset( $_POST['shurloc_action'] ) ) {
		return;
	}

	$action = sanitize_key(
		wp_unslash( $_POST['shurloc_action'] )
	);

	switch ( $action ) {

		case 'export_variations':
			check_admin_referer( 'shurloc_export_variations' );
			shurloc_export_variations();
			break;

		case 'generate_catalog_report':
			check_admin_referer( 'shurloc_generate_catalog_report' );
			shurloc_generate_catalog_report();
			break;
	}
}

/**
 * Collect all WooCommerce variation names.
 *
 * @return string[]
 */
function shurloc_get_catalog_variations(): array {

	$variations = array();

	foreach ( shurloc_get_catalog_entries() as $entry ) {
		$variations[] = $entry->variation;
	}

	return $variations;
}

/**
 * Collect catalog variation entries from WooCommerce.
 *
 * Each entry represents a single product variation and includes the
 * information needed for catalog analysis and reporting.
 *
 * @return Shurloc_Catalog_Variation_Entry[]
 */
function shurloc_get_catalog_entries(): array {

	$entries = array();

	$product_ids = get_posts(
		array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);

	foreach ( $product_ids as $product_id ) {

		$product = wc_get_product( $product_id );

		if ( ! $product || ! $product->is_type( 'variable' ) ) {
			continue;
		}

		foreach ( $product->get_children() as $variation_id ) {

			$variation = wc_get_product( $variation_id );

			if ( ! $variation ) {
				continue;
			}

			$attributes = $variation->get_variation_attributes();

			if ( 1 !== count( $attributes ) ) {
				continue;
			}

			$raw_price = $variation->get_price();

			$price = (
				'' === $raw_price
					? null
					: (float) $raw_price
			);

			$entries[] = new Shurloc_Catalog_Variation_Entry(
				array_values( $attributes )[0],
				$price,
				$product_id,
				$product->get_name(),
				get_edit_post_link(
					$product_id,
					''
				)
			);
		}
	}

	usort(
		$entries,
		static function (
			Shurloc_Catalog_Variation_Entry $left,
			Shurloc_Catalog_Variation_Entry $right
		): int {

			return strnatcasecmp(
				$left->variation,
				$right->variation
			);
		}
	);

	return $entries;
}

/**
 * Download data as a JSON file.
 *
 * @param string $filename Download filename.
 * @param array  $data     Data to encode as JSON.
 */
function shurloc_download_json(
	string $filename,
	array $data
): void {

	header( 'Content-Type: application/json; charset=utf-8' );
	header(
		sprintf(
			'Content-Disposition: attachment; filename="%s"',
			$filename
		)
	);
	header( 'Cache-Control: no-cache, no-store, must-revalidate' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );

	echo wp_json_encode(
		$data,
		JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
	);

	exit;
}
