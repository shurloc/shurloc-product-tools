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

		$GLOBALS['shurloc_test_registered_styles'] = array();
	}

	/**
	 * Registers frontend enqueue hook.
	 *
	 * @return void
	 */
	public function test_registers_register_styles_hook(): void {

		$assets = new Shurloc_Mesh_Product_Table_Assets(
			'https://example.com/plugins/shurloc-product-tools/',
			'1.0.0'
		);

		$assets->register();

		$this->assertNotFalse(
			has_action(
				'wp_enqueue_scripts',
				array(
					$assets,
					'register_styles',
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
			'https://example.com/plugin/',
			'1.2.3'
		);

		$assets->register_styles();

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
			'1.2.3',
			$style['ver']
		);
	}
}
