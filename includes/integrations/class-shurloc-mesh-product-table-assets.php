<?php
/**
 * Mesh product table assets.
 *
 * Registers and enqueues frontend assets for the mesh product table.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product table assets.
 */
final class Shurloc_Mesh_Product_Table_Assets {

	/**
	 * Register frontend hooks.
	 *
	 * @return void
	 */
	public function register(): void {

		add_action(
			'wp_enqueue_scripts',
			array(
				$this,
				'enqueue_styles',
			)
		);
	}

	/**
	 * Enqueue mesh product table stylesheet.
	 *
	 * @return void
	 */
	public function enqueue_styles(): void {

		if ( ! is_singular() ) {
			return;
		}

		global $post;

		if ( ! $post instanceof WP_Post ) {
			return;
		}

		if ( ! has_shortcode(
			$post->post_content,
			'shurloc_mesh_table'
		) ) {
			return;
		}

		wp_enqueue_style(
			'shurloc-mesh-product-table',
			SHURLOC_PRODUCT_TOOLS_URL . 'assets/css/shurloc-mesh-product-table.css',
			array(),
			SHURLOC_PRODUCT_TOOLS_VERSION
		);
	}
}
