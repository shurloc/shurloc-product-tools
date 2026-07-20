<?php
/**
 * Catalog report admin controller.
 *
 * Provides admin tools for exporting and analyzing the WooCommerce catalog.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Catalog report admin controller.
 */
final class Shurloc_Catalog_Report_Controller implements Shurloc_Catalog_Report_Actions_Interface {

	/**
	 * Product catalog service.
	 *
	 * @var Shurloc_Product_Catalog_Service
	 */
	private Shurloc_Product_Catalog_Service $catalog_service;

	/**
	 * Request handler.
	 *
	 * @var Shurloc_Catalog_Report_Request_Handler
	 */
	private Shurloc_Catalog_Report_Request_Handler $request_handler;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Product_Catalog_Service $catalog_service Product catalog service.
	 */
	public function __construct(
		Shurloc_Product_Catalog_Service $catalog_service
	) {

		$this->catalog_service = $catalog_service;

		$this->request_handler = new Shurloc_Catalog_Report_Request_Handler(
			$this
		);
	}

	/**
	 * Register admin hooks.
	 *
	 * @return void
	 */
	public function register(): void {

		add_action(
			'admin_init',
			array(
				$this->request_handler,
				'handle_request',
			)
		);

		add_action(
			'admin_menu',
			array(
				$this,
				'register_menu',
			)
		);
	}

	/**
	 * Register the Shur-Loc Product Tools page.
	 *
	 * @return void
	 */
	public function register_menu(): void {

		add_management_page(
			'Shur-Loc Product Tools',
			'Shur-Loc Product Tools',
			'manage_options',
			'shurloc-product-tools',
			array(
				$this,
				'render_page',
			)
		);
	}

	/**
	 * Render the Product Tools page.
	 *
	 * @return void
	 */
	public function render_page(): void {
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
	 *
	 * @return void
	 */
	public function export_variations(): void {

		$this->verify_permissions();

		$this->download_json(
			'shurloc-variations.json',
			$this->get_catalog_variations()
		);
	}

	/**
	 * Generate a catalog analysis report.
	 *
	 * @return void
	 */
	public function generate_catalog_report(): void {

		$this->verify_permissions();

		$parser = new Shurloc_Mesh_Parser();

		$analyzer = new Shurloc_Catalog_Analyzer(
			$parser
		);

		$report = $analyzer->analyze(
			$this->get_catalog_entries()
		);

		$this->download_json(
			'catalog-report.json',
			$report->to_array()
		);
	}

	/**
	 * Collect all WooCommerce variation names.
	 *
	 * @return string[]
	 */
	private function get_catalog_variations(): array {

		$variations = array();

		foreach ( $this->get_catalog_entries() as $entry ) {

			$variations[] = $entry->variation;
		}

		return $variations;
	}

	/**
	 * Collect catalog variation entries from WooCommerce.
	 *
	 * @return Shurloc_Catalog_Variation_Entry[]
	 */
	private function get_catalog_entries(): array {

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

			if ( ! $product ) {
				continue;
			}

			$entries = array_merge(
				$entries,
				$this->catalog_service->get_product_variation_entries(
					$product
				)
			);
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
	 * Verify administrator permissions.
	 *
	 * @return void
	 */
	private function verify_permissions(): void {

		if ( ! current_user_can( 'manage_options' ) ) {

			wp_die(
				esc_html__(
					'You do not have permission to perform this action.',
					'shurloc-product-tools'
				)
			);
		}
	}

	/**
	 * Download data as JSON.
	 *
	 * @param string $filename Download filename.
	 * @param array  $data     Data to encode as JSON.
	 * @return void
	 */
	private function download_json(
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
}
