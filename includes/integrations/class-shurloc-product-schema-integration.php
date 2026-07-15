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
	 * Catalog service.
	 *
	 * @var Shurloc_Product_Catalog_Service
	 */
	private Shurloc_Product_Catalog_Service $catalog_service;

	/**
	 * Product schema service.
	 *
	 * @var Shurloc_Product_Schema_Service
	 */
	private Shurloc_Product_Schema_Service $schema_service;

	/**
	 * Product schema renderer.
	 *
	 * @var Shurloc_Product_Schema_Renderer
	 */
	private Shurloc_Product_Schema_Renderer $renderer;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Product_Catalog_Service $catalog_service Catalog service.
	 * @param Shurloc_Product_Schema_Service  $schema_service Product schema service.
	 * @param Shurloc_Product_Schema_Renderer $renderer Product schema renderer.
	 */
	public function __construct(
		Shurloc_Product_Catalog_Service $catalog_service,
		Shurloc_Product_Schema_Service $schema_service,
		Shurloc_Product_Schema_Renderer $renderer
	) {

		$this->catalog_service = $catalog_service;
		$this->schema_service  = $schema_service;
		$this->renderer        = $renderer;
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

		if ( ! is_product() ) {
			return;
		}

		$product = wc_get_product(
			get_the_ID()
		);

		if ( ! $product ) {
			return;
		}

		$entry = $this->catalog_service->get_product_entry(
			$product
		);

		if ( null === $entry ) {
			return;
		}

		$schema = $this->schema_service->generate(
			$entry
		);

		$this->renderer->render(
			$schema
		);
	}
}
