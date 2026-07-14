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
	 * Catalog service.
	 *
	 * @var Shurloc_Product_Catalog_Service
	 */
	private Shurloc_Product_Catalog_Service $catalog_service;

	/**
	 * Schema service.
	 *
	 * @var Shurloc_Mesh_Product_Schema_Service
	 */
	private Shurloc_Mesh_Product_Schema_Service $schema_service;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Product_Catalog_Service     $catalog_service Catalog service.
	 * @param Shurloc_Mesh_Product_Schema_Service $schema_service Schema service.
	 */
	public function __construct(
		Shurloc_Product_Catalog_Service $catalog_service,
		Shurloc_Mesh_Product_Schema_Service $schema_service
	) {

		$this->catalog_service = $catalog_service;
		$this->schema_service  = $schema_service;
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

		$entry = $this->catalog_service->get_product_entry(
			$product
		);

		if ( null === $entry ) {
			return;
		}

		$schema = $this->schema_service->generate(
			$entry
		);

		if ( null === $schema ) {
			return;
		}

		echo '<script type="application/ld+json">';
		echo wp_json_encode(
			$schema,
			JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
		);
		echo '</script>';
		echo "\n";
	}
}
