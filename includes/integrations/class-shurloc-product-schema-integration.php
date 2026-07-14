<?php
/**
 * Product schema integration.
 *
 * Registers product schema rendering hooks.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Product schema integration.
 */
final class Shurloc_Product_Schema_Integration {

	/**
	 * Product schema renderer.
	 *
	 * @var Shurloc_Product_Schema_Renderer
	 */
	private Shurloc_Product_Schema_Renderer $renderer;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Product_Schema_Renderer $renderer Product schema renderer.
	 */
	public function __construct(
		Shurloc_Product_Schema_Renderer $renderer
	) {

		$this->renderer = $renderer;
	}

	/**
	 * Register integration hooks.
	 *
	 * @return void
	 */
	public function register(): void {

		add_action(
			'wp_head',
			array(
				$this,
				'render_product_schema',
			),
			20
		);
	}

	/**
	 * Render product schema.
	 *
	 * @return void
	 */
	public function render_product_schema(): void {

		$this->renderer->render();
	}
}
