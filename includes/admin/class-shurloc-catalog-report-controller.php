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
	 * Catalog report tab slug.
	 *
	 * @var string
	 */
	private const TAB_CATALOG_REPORT = 'catalog-report';

	/**
	 * Invalid mesh products tab slug.
	 *
	 * @var string
	 */
	private const TAB_INVALID_MESH_PRODUCTS = 'invalid-mesh-products';

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
			actions: $this,
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

		$active_tab = $this->get_active_tab();
		?>

		<div class="wrap">

			<h1>Shur-Loc Product Tools</h1>

			<p>
				Utilities for exporting and analyzing the WooCommerce product catalog.
			</p>

			<?php $this->render_tabs( active_tab: $active_tab ); ?>

			<?php
			switch ( $active_tab ) {

				case self::TAB_INVALID_MESH_PRODUCTS:
					$this->render_invalid_mesh_products_tab();
					break;

				case self::TAB_CATALOG_REPORT:
				default:
					$this->render_catalog_report_tab();
					break;
			}
			?>

		</div>

		<?php
	}

	/**
	 * Render the admin navigation tabs.
	 *
	 * @param string $active_tab Active tab slug.
	 * @return void
	 */
	private function render_tabs(
		string $active_tab
	): void {

		$tabs = array(
			self::TAB_CATALOG_REPORT        => 'Catalog Report',
			self::TAB_INVALID_MESH_PRODUCTS => 'Invalid Mesh Products',
		);
		?>

		<nav class="nav-tab-wrapper">

			<?php foreach ( $tabs as $tab_slug => $tab_label ) : ?>

				<?php
				$tab_url = add_query_arg(
					array(
						'page' => 'shurloc-product-tools',
						'tab'  => $tab_slug,
					),
					admin_url( 'tools.php' )
				);

				$tab_classes = array(
					'nav-tab',
				);

				if ( $active_tab === $tab_slug ) {
					$tab_classes[] = 'nav-tab-active';
				}
				?>

				<a
					href="<?php echo esc_url( $tab_url ); ?>"
					class="<?php echo esc_attr( implode( ' ', $tab_classes ) ); ?>"
				>
					<?php echo esc_html( $tab_label ); ?>
				</a>

			<?php endforeach; ?>

		</nav>

		<?php
	}

	/**
	 * Render the catalog report tab.
	 *
	 * @return void
	 */
	private function render_catalog_report_tab(): void {
		?>

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

		<?php
	}


	/**
	 * Render the invalid mesh products tab.
	 *
	 * @return void
	 */
	private function render_invalid_mesh_products_tab(): void {
		?>

		<h2>Invalid Mesh Products</h2>

		<p>
			Review product variations that could not be recognized as valid
			mesh specifications.
		</p>

		<div class="notice notice-info inline">

			<p>
				The invalid mesh products report is under development.
			</p>

		</div>

		<?php
	}

	/**
	 * Get the active admin tab.
	 *
	 * @return string
	 */
	private function get_active_tab(): string {

		$active_tab = self::TAB_CATALOG_REPORT;

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['tab'] ) ) {

			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$requested_tab = sanitize_key( wp_unslash( $_GET['tab'] ) );

			if (
				in_array(
					$requested_tab,
					array(
						self::TAB_CATALOG_REPORT,
						self::TAB_INVALID_MESH_PRODUCTS,
					),
					true
				)
			) {
				$active_tab = $requested_tab;
			}
		}

		return $active_tab;
	}

	/**
	 * Export WooCommerce catalog variations.
	 *
	 * @return void
	 */
	public function export_variations(): void {

		$this->verify_permissions();

		$this->download_json(
			filename: 'shurloc-variations.json',
			data: $this->get_catalog_variations(),
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
			parser: $parser,
		);

		$report = $analyzer->analyze(
			entries: $this->get_catalog_entries(),
		);

		$this->download_json(
			filename: 'catalog-report.json',
			data: $report->to_array(),
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
			),
		);

		foreach ( $product_ids as $product_id ) {

			$product = wc_get_product( $product_id );

			if ( ! $product ) {
				continue;
			}

			$entries = array_merge(
				$entries,
				$this->catalog_service->get_product_variation_entries(
					product: $product,
				),
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