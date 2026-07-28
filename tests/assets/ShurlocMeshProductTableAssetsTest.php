<?php
/**
 * Tests for mesh product table assets.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests mesh product table asset handling.
 */
final class ShurlocMeshProductTableAssetsTest extends TestCase {

	/**
	 * Test setup.
	 *
	 * @return void
	 */
	protected function setUp(): void {

		parent::setUp();

		$GLOBALS['post'] = null;

		$GLOBALS['shurloc_test_registered_styles']  = array();
		$GLOBALS['shurloc_test_registered_scripts'] = array();
	}

	/**
	 * Registers frontend enqueue hook.
	 *
	 * @return void
	 */
	public function test_registers_register_assets_hook(): void {

		$assets = new Shurloc_Mesh_Product_Table_Assets(
			asset_url: 'https://example.com/plugins/shurloc-product-tools/',
			asset_version: '1.0.0'
		);

		$assets->register();

		$this->assertNotFalse(
			has_action(
				'wp_enqueue_scripts',
				array(
					$assets,
					'register_assets',
				)
			)
		);
	}

	/**
	 * Test that the stylesheet gets registered.
	 *
	 * @return void
	 */
	public function test_registers_stylesheet(): void {

		$assets = new Shurloc_Mesh_Product_Table_Assets(
			asset_url: 'https://example.com/plugin/',
			asset_version: '1.2.3'
		);

		$assets->register_assets();

		$this->assertTrue(
			wp_style_is(
				Shurloc_Mesh_Product_Table_Assets::STYLE_HANDLE,
				'registered'
			)
		);

		$this->assertArrayHasKey(
			Shurloc_Mesh_Product_Table_Assets::STYLE_HANDLE,
			$GLOBALS['shurloc_test_registered_styles']
		);

		$style = $GLOBALS['shurloc_test_registered_styles'][ Shurloc_Mesh_Product_Table_Assets::STYLE_HANDLE ];

		$this->assertSame(
			'https://example.com/plugin/assets/css/shurloc-mesh-product-table.css',
			$style['src']
		);

		$this->assertSame(
			array(),
			$style['deps']
		);

		$this->assertSame(
			'1.2.3',
			$style['ver']
		);
	}

	/**
	 * Test that the script gets registered.
	 *
	 * @return void
	 */
	public function test_registers_script(): void {

		$assets = new Shurloc_Mesh_Product_Table_Assets(
			asset_url: 'https://example.com/plugin/',
			asset_version: '1.2.3'
		);

		$assets->register_assets();

		$this->assertTrue(
			wp_script_is(
				Shurloc_Mesh_Product_Table_Assets::SCRIPT_HANDLE,
				'registered'
			)
		);

		$this->assertArrayHasKey(
			Shurloc_Mesh_Product_Table_Assets::SCRIPT_HANDLE,
			$GLOBALS['shurloc_test_registered_scripts']
		);

		$script = $GLOBALS['shurloc_test_registered_scripts'][ Shurloc_Mesh_Product_Table_Assets::SCRIPT_HANDLE ];

		$this->assertSame(
			'https://example.com/plugin/assets/js/shurloc-mesh-product-table.js',
			$script['src']
		);

		$this->assertSame(
			array(),
			$script['deps']
		);

		$this->assertSame(
			'1.2.3',
			$script['ver']
		);

		$this->assertTrue(
			$script['in_footer']
		);
	}
}
