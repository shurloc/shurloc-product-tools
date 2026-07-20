<?php
/**
 * Product catalog service test double.
 *
 * Provides a controllable implementation of the product catalog service
 * interface for unit testing services that depend on catalog data retrieval.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Product catalog service test double.
 */
final class Shurloc_Product_Catalog_Service_Double implements Shurloc_Product_Catalog_Service_Interface {

	/**
	 * Catalog variation entries to return.
	 *
	 * @var Shurloc_Catalog_Variation_Entry[]
	 */
	private array $variation_entries;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Catalog_Variation_Entry[] $variation_entries Variation entries.
	 */
	public function __construct(
		array $variation_entries = array()
	) {

		$this->variation_entries = $variation_entries;
	}

	/**
	 * Get catalog product entry.
	 *
	 * This method is included to satisfy the interface contract. Tests should
	 * provide this behavior only when a consumer requires product entries.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return Shurloc_Catalog_Product_Entry Product entry.
	 */
	public function get_product_entry(
		WC_Product $product
	): Shurloc_Catalog_Product_Entry {

		return new Shurloc_Catalog_Product_Entry(
			(int) $product->get_id(),
			$product->get_name(),
			'',
			'',
			'',
			null,
			null,
			null,
			null,
			'https://schema.org/InStock',
			'Shur-loc®',
			'Shur-loc®',
			null,
			array(),
			$this->variation_entries
		);
	}

	/**
	 * Get catalog variation entries.
	 *
	 * Returns the predefined variation entries supplied during construction.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return Shurloc_Catalog_Variation_Entry[] Variation entries.
	 */
	public function get_product_variation_entries(
		WC_Product $product
	): array {

		return $this->variation_entries;
	}
}
