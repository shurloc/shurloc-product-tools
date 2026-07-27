<?php
/**
 * Tests for catalog report controller.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests catalog report admin controller.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class ShurlocCatalogReportControllerTest extends TestCase {

	/**
	 * Set up test environment.
	 *
	 * @return void
	 */
	protected function setUp(): void {

		parent::setUp();

		$GLOBALS['shurloc_test_actions']         = array();
		$GLOBALS['shurloc_test_action_metadata'] = array();
	}

	/**
	 * Controller should register admin hooks.
	 *
	 * @return void
	 */
	public function test_controller_registers_admin_hooks(): void {

		$controller = new Shurloc_Catalog_Report_Controller(
			new Shurloc_Product_Catalog_Service()
		);

		$controller->register();

		$this->assertArrayHasKey(
			'admin_init',
			$GLOBALS['shurloc_test_actions']
		);

		$this->assertArrayHasKey(
			'admin_menu',
			$GLOBALS['shurloc_test_actions']
		);
	}

	/**
	 * Admin init callback should be callable.
	 *
	 * @return void
	 */
	public function test_admin_init_callback_is_registered(): void {

		$controller = new Shurloc_Catalog_Report_Controller(
			new Shurloc_Product_Catalog_Service()
		);

		$controller->register();

		$this->assertIsCallable(
			$GLOBALS['shurloc_test_actions']['admin_init'][0]
		);
	}

	/**
	 * Admin menu callback should be callable.
	 *
	 * @return void
	 */
	public function test_admin_menu_callback_is_registered(): void {

		$controller = new Shurloc_Catalog_Report_Controller(
			new Shurloc_Product_Catalog_Service()
		);

		$controller->register();

		$this->assertIsCallable(
			$GLOBALS['shurloc_test_actions']['admin_menu'][0]
		);
	}
}
