<?php
/**
 * Tests for the Product Tools admin page controller.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests the Product Tools admin page controller.
 */
final class ShurlocAdminPageControllerTest extends TestCase {

	/**
	 * Catalog report controller.
	 *
	 * @var Shurloc_Catalog_Report_Controller
	 */
	private Shurloc_Catalog_Report_Controller $catalog_report_controller;

	/**
	 * Migrations controller.
	 *
	 * @var Shurloc_Product_Migrations_Controller
	 */
	private Shurloc_Product_Migrations_Controller $migrations_controller;

	/**
	 * Admin page controller.
	 *
	 * @var Shurloc_Admin_Page_Controller
	 */
	private Shurloc_Admin_Page_Controller $controller;

	/**
	 * Prepare each test.
	 *
	 * @return void
	 */
	protected function setUp(): void {

		parent::setUp();

		$_GET = array();

		$catalog_service =
			new Shurloc_Product_Catalog_Service();

		$mesh_parser =
			new Shurloc_Mesh_Parser();

		$catalog_analyzer =
			new Shurloc_Catalog_Analyzer(
				mesh_parser: $mesh_parser,
			);

		$analysis_service =
			new Shurloc_Catalog_Analysis_Service(
				catalog_service: $catalog_service,
				catalog_analyzer: $catalog_analyzer,
			);

		$this->catalog_report_controller =
			new Shurloc_Catalog_Report_Controller(
				catalog_service: $catalog_service,
				analysis_service: $analysis_service,
			);

		$cleanup_migration =
			new Shurloc_Yoast_Product_Meta_Cleanup_Migration();

		$this->migrations_controller =
			new Shurloc_Product_Migrations_Controller(
				cleanup_migration: $cleanup_migration,
			);

		$this->controller =
			new Shurloc_Admin_Page_Controller(
				catalog_report_controller:
					$this->catalog_report_controller,
				migrations_controller:
					$this->migrations_controller,
			);
	}

	/**
	 * Clean up after each test.
	 *
	 * @return void
	 */
	protected function tearDown(): void {

		$_GET = array();

		parent::tearDown();
	}

	/**
	 * Verify the Product Tools page shell is rendered.
	 *
	 * @return void
	 */
	public function test_render_page_shows_page_shell(): void {

		ob_start();

		$this->controller->render_page();

		$output = (string) ob_get_clean();

		self::assertStringContainsString(
			'Shur-loc Product Tools',
			$output
		);

		self::assertStringContainsString(
			'Product administration, reporting, migrations, and catalog tools.',
			$output
		);

		self::assertStringContainsString(
			'class="wrap"',
			$output
		);
	}

	/**
	 * Verify all Product Tools tabs are rendered.
	 *
	 * @return void
	 */
	public function test_render_page_shows_all_tabs(): void {

		ob_start();

		$this->controller->render_page();

		$output = (string) ob_get_clean();

		self::assertStringContainsString(
			'Catalog Report',
			$output
		);

		self::assertStringContainsString(
			'Invalid Mesh Products',
			$output
		);

		self::assertStringContainsString(
			'Unrecognized Mesh Products',
			$output
		);

		self::assertStringContainsString(
			'Migrations',
			$output
		);
	}

	/**
	 * Verify the catalog report tab is active by default.
	 *
	 * @return void
	 */
	public function test_render_page_defaults_to_catalog_report_tab(): void {

		ob_start();

		$this->controller->render_page();

		$output = (string) ob_get_clean();

		self::assertMatchesRegularExpression(
			'/tab=catalog-report[^"]*"[^>]*class="nav-tab nav-tab-active"/',
			$output
		);

		self::assertStringContainsString(
			'Export Catalog Variations',
			$output
		);
	}

	/**
	 * Verify the catalog report tab can be selected explicitly.
	 *
	 * @return void
	 */
	public function test_render_page_routes_catalog_report_tab(): void {

		$_GET['tab'] = 'catalog-report';

		ob_start();

		$this->controller->render_page();

		$output = (string) ob_get_clean();

		self::assertStringContainsString(
			'Export Catalog Variations',
			$output
		);

		self::assertStringContainsString(
			'Generate Catalog Report',
			$output
		);
	}

	/**
	 * Verify the invalid mesh products tab is routed correctly.
	 *
	 * @return void
	 */
	public function test_render_page_routes_invalid_mesh_products_tab(): void {

		$_GET['tab'] = 'invalid-mesh-products';

		ob_start();

		$this->controller->render_page();

		$output = (string) ob_get_clean();

		self::assertStringContainsString(
			'<h2>Invalid Mesh Products</h2>',
			$output
		);
	}

	/**
	 * Verify the unrecognized mesh products tab is routed correctly.
	 *
	 * @return void
	 */
	public function test_render_page_routes_unrecognized_mesh_products_tab(): void {

		$_GET['tab'] = 'unrecognized-mesh-products';

		ob_start();

		$this->controller->render_page();

		$output = (string) ob_get_clean();

		self::assertStringContainsString(
			'<h2>Unrecognized Mesh Products</h2>',
			$output
		);
	}

	/**
	 * Verify the migrations tab is routed correctly.
	 *
	 * @return void
	 */
	public function test_render_page_routes_migrations_tab(): void {

		$_GET['tab'] = 'migrations';

		ob_start();

		$this->controller->render_page();

		$output = (string) ob_get_clean();

		self::assertStringContainsString(
			'Product Data Migrations',
			$output
		);

		self::assertStringContainsString(
			'Yoast Product Metadata Cleanup',
			$output
		);
	}

	/**
	 * Verify an invalid tab falls back to the catalog report.
	 *
	 * @return void
	 */
	public function test_render_page_falls_back_to_catalog_report_for_invalid_tab(): void {

		$_GET['tab'] = 'invalid-tab';

		ob_start();

		$this->controller->render_page();

		$output = (string) ob_get_clean();

		self::assertStringContainsString(
			'Export Catalog Variations',
			$output
		);

		self::assertStringNotContainsString(
			'Yoast Product Metadata Cleanup',
			$output
		);
	}

	/**
	 * Verify migration tab links use the Product Tools admin page.
	 *
	 * @return void
	 */
	public function test_render_page_builds_migrations_tab_url(): void {

		ob_start();

		$this->controller->render_page();

		$output = (string) ob_get_clean();

		self::assertStringContainsString(
			'page=shurloc-product-tools',
			$output
		);

		self::assertStringContainsString(
			'tab=migrations',
			$output
		);
	}
}
