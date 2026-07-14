<?php
/**
 * Product schema output integration.
 *
 * Outputs generated product schema as JSON-LD.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Product schema output.
 */
final class Shurloc_Product_Schema_Output {

	/**
	 * Schema service.
	 *
	 * @var Shurloc_Mesh_Product_Schema_Service
	 */
	private Shurloc_Mesh_Product_Schema_Service $service;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Mesh_Product_Schema_Service $service Schema service.
	 */
	public function __construct(
		Shurloc_Mesh_Product_Schema_Service $service
	) {

		$this->service = $service;
	}

	/**
	 * Output product schema.
	 *
	 * @return void
	 */
	public function output(): void {

		if ( ! is_product() ) {
			return;
		}

		$product = wc_get_product(
			get_the_ID()
		);

		if ( ! $product ) {
			return;
		}

		$catalog_service = new Shurloc_Product_Catalog_Service();

		$entry = $catalog_service->get_product_entry(
			$product
		);

		if ( null === $entry ) {
			return;
		}

		$schema = $this->service->generate(
			$entry
		);

		if ( null === $schema ) {
			return;
		}

		echo '<script type="application/ld+json">';
		echo wp_json_encode(
			$schema,
			JSON_UNESCAPED_SLASHES
		);
		echo '</script>';
	}
}
