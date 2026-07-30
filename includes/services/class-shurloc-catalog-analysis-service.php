<?php
/**
 * Catalog analysis service.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Collects and analyzes WooCommerce catalog variations.
 */
final class Shurloc_Catalog_Analysis_Service implements Shurloc_Catalog_Analysis_Service_Interface {

	/**
	 * Product catalog service.
	 *
	 * @var Shurloc_Product_Catalog_Service_Interface
	 */
	private Shurloc_Product_Catalog_Service_Interface $catalog_service;

	/**
	 * Catalog analyzer.
	 *
	 * @var Shurloc_Catalog_Analyzer
	 */
	private Shurloc_Catalog_Analyzer $analyzer;


	/**
	 * Constructor.
	 *
	 * @param Shurloc_Product_Catalog_Service_Interface $catalog_service Product catalog service.
	 * @param Shurloc_Catalog_Analyzer                  $analyzer        Catalog analyzer.
	 */
	public function __construct(
		Shurloc_Product_Catalog_Service_Interface $catalog_service,
		Shurloc_Catalog_Analyzer $analyzer
	) {

		$this->catalog_service = $catalog_service;
		$this->analyzer        = $analyzer;
	}


	/**
	 * Collect catalog variation entries.
	 *
	 * @return Shurloc_Catalog_Variation_Entry[]
	 */
	public function get_variation_entries(): array {

		$entries = array();

		$product_ids = get_posts(
			array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);

		foreach ( $product_ids as $product_id ) {

			$product = wc_get_product( $product_id );

			if ( ! $product ) {
				continue;
			}

			$product_entries = $this->catalog_service->get_product_variation_entries(
				product: $product,
			);

			$entries = array_merge(
				$entries,
				$product_entries
			);
		}

		usort(
			$entries,
			static function (
				Shurloc_Catalog_Variation_Entry $left,
				Shurloc_Catalog_Variation_Entry $right
			): int {

				return strnatcasecmp(
					$left->variation,
					$right->variation
				);
			}
		);

		return $entries;
	}


	/**
	 * Collect catalog variation values.
	 *
	 * @return string[]
	 */
	public function get_variation_values(): array {

		return array_map(
			static function (
				Shurloc_Catalog_Variation_Entry $entry
			): string {

				return $entry->variation;
			},
			$this->get_variation_entries()
		);
	}


	/**
	 * Analyze the WooCommerce catalog.
	 *
	 * @return Shurloc_Mesh_Product_Result
	 */
	public function analyze(): Shurloc_Mesh_Product_Result {

		return $this->analyzer->analyze(
			entries: $this->get_variation_entries(),
		);
	}
}
