<?php
/**
 * Tests for plugin entry point.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests plugin registration.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class ShurlocPluginEntryTest extends TestCase {

	/**
	 * Test environment setup.
	 *
	 * @return void
	 */
	protected function setUp(): void {

		parent::setUp();

		$GLOBALS['shurloc_test_actions'] = array();

		$GLOBALS['shurloc_test_action_metadata'] = array();
	}

	/**
	 * Plugin should register bootstrap hook.
	 *
	 * @return void
	 */
	public function test_plugin_registers_bootstrap_hook(): void {

		require dirname( __DIR__, 2 ) . '/shurloc-product-tools.php';

		$this->assertArrayHasKey(
			'plugins_loaded',
			$GLOBALS['shurloc_test_actions']
		);

		$this->assertSame(
			'shurloc_product_tools_bootstrap',
			$GLOBALS['shurloc_test_actions']['plugins_loaded'][0]
		);

		$this->assertSame(
			10,
			$GLOBALS['shurloc_test_action_metadata']['plugins_loaded'][0]['priority']
		);

		$this->assertSame(
			1,
			$GLOBALS['shurloc_test_action_metadata']['plugins_loaded'][0]['accepted_args']
		);
	}
}
