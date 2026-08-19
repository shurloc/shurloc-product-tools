<?php
/**
 * Tests for plugin bootstrap.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests plugin initialization.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class ShurlocPluginBootstrapTest extends TestCase {

	/**
	 * Set up bootstrap test environment.
	 */
	protected function setUp(): void {

		parent::setUp();

		$GLOBALS['shurloc_test_actions'] = array();

		$GLOBALS['shurloc_test_action_metadata'] = array();
	}

	/**
	 * Bootstrap function should exist.
	 */
	public function test_bootstrap_function_exists(): void {

		$this->load_plugin();

		$this->assertTrue(
			function_exists(
				'shurloc_product_tools_bootstrap'
			)
		);
	}

	/**
	 * Bootstrap should register plugin services without errors.
	 */
	public function test_bootstrap_runs_successfully(): void {

		$this->load_plugin();

		shurloc_product_tools_bootstrap();

		$this->assertTrue(
			class_exists(
				Shurloc_Product_Catalog_Service::class
			)
		);

		$this->assertTrue(
			class_exists(
				Shurloc_Product_Schema_Service::class
			)
		);

		$this->assertTrue(
			class_exists(
				Shurloc_WooCommerce_Schema_Integration::class
			)
		);

		$this->assertArrayHasKey(
			'wp_head',
			$GLOBALS['shurloc_test_actions']
		);
	}

	/**
	 * Bootstrap should initialize the autoloader.
	 *
	 * @return void
	 */
	public function test_bootstrap_registers_autoloader(): void {

		shurloc_product_tools_bootstrap();

		$this->assertTrue(
			class_exists(
				Shurloc_Autoloader::class
			)
		);
	}

	/**
	 * Load plugin file.
	 */
	private function load_plugin(): void {

		require_once dirname( __DIR__, 2 ) . '/shurloc-product-tools.php';
	}
}
