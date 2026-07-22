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
	 * Asset URL.
	 *
	 * @var string
	 */
	private string $asset_url;

	/**
	 * Asset version.
	 *
	 * @var string
	 */
	private string $asset_version;

	/**
	 * Constructor.
	 *
	 * @param string $asset_url     Base asset URL.
	 * @param string $asset_version Asset version.
	 */
	public function __construct(
		string $asset_url,
		string $asset_version
	) {
		$this->asset_url     = $asset_url;
		$this->asset_version = $asset_version;
	}

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
			$this->asset_url . 'assets/css/shurloc-mesh-product-table.css',
			array(),
			$this->asset_version
		);
	}
}
