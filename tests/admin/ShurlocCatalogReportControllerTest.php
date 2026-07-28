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
 */
final class ShurlocCatalogReportControllerTest extends TestCase {

	/**
	 * Catalog report controller.
	 *
	 * @var Shurloc_Catalog_Report_Controller
	 */
	private Shurloc_Catalog_Report_Controller $controller;

	/**
	 * Set up test environment.
	 */
	protected function setUp(): void {

		parent::setUp();

		$GLOBALS['shurloc_test_actions']         = array();
		$GLOBALS['shurloc_test_action_metadata'] = array();

		$this->controller = new Shurloc_Catalog_Report_Controller(
			catalog_service: new Shurloc_Product_Catalog_Service(),
		);
	}

	/**
	 * Controller should register admin hooks.
	 */
	public function test_controller_registers_admin_hooks(): void {

		$this->controller->register();

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
	 */
	public function test_admin_init_callback_is_registered(): void {

		$this->controller->register();

		$this->assertIsCallable(
			$GLOBALS['shurloc_test_actions']['admin_init'][0]
		);
	}

	/**
	 * Admin menu callback should be callable.
	 */
	public function test_admin_menu_callback_is_registered(): void {

		$this->controller->register();

		$this->assertIsCallable(
			$GLOBALS['shurloc_test_actions']['admin_menu'][0]
		);
	}
}
