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

		$GLOBALS['shurloc_test_styles'] = array();
	}

	/**
	 * Registers frontend enqueue hook.
	 *
	 * @return void
	 */
	public function test_registers_enqueue_hook(): void {

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
					'enqueue_styles',
				)
			)
		);
	}

	/**
	 * Does not enqueue stylesheet without mesh table shortcode.
	 *
	 * @return void
	 */
	public function test_does_not_enqueue_without_mesh_table_shortcode(): void {

		$post = new WP_Post();

		$post->post_content = 'Regular product content.';

		$GLOBALS['post'] = $post;

		$assets = new Shurloc_Mesh_Product_Table_Assets(
			'https://example.com/plugins/shurloc-product-tools/',
			'1.0.0'
		);

		$assets->enqueue_styles();

		$this->assertFalse(
			wp_style_is(
				'shurloc-mesh-product-table',
				'enqueued'
			)
		);
	}

	/**
	 * Enqueues stylesheet when mesh table shortcode exists.
	 *
	 * @return void
	 */
	public function test_enqueues_with_mesh_table_shortcode(): void {

		$post = new WP_Post();

		$post->post_content = '[shurloc_mesh_table]';

		$GLOBALS['post'] = $post;

		$assets = new Shurloc_Mesh_Product_Table_Assets(
			'https://example.com/plugins/shurloc-product-tools/',
			'1.0.0'
		);

		$assets->enqueue_styles();

		$this->assertTrue(
			wp_style_is(
				'shurloc-mesh-product-table',
				'enqueued'
			)
		);
	}
}
