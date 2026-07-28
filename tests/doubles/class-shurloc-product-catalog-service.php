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
	 * Calls to get_product_entry().
	 *
	 * @var WC_Product[]
	 */
	private array $product_entry_calls = array();

	/**
	 * Calls to get_product_variation_entries().
	 *
	 * @var WC_Product[]
	 */
	private array $variation_entry_calls = array();

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
		WC_Product $product,
	): Shurloc_Catalog_Product_Entry {

		$this->product_entry_calls[] = $product;

		return new Shurloc_Catalog_Product_Entry(
			product_id: (int) $product->get_id(),
			product_name: $product->get_name(),
			edit_url: '',
			product_url: '',
			sku: '',
			image_url: null,
			short_description: null,
			description: null,
			category: null,
			price: null,
			regular_price: null,
			sale_price: null,
			availability: 'https://schema.org/InStock',
			brand: 'Shur-loc®',
			manufacturer: 'Shur-loc®',
			aggregate_rating: null,
			reviews: array(),
			variations: $this->variation_entries,
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
		WC_Product $product,
	): array {

		$this->variation_entry_calls[] = $product;

		return $this->variation_entries;
	}

	/**
	 * Get calls to get_product_entry().
	 *
	 * @return WC_Product[] Products passed to get_product_entry().
	 */
	public function get_product_entry_calls(): array {

		return $this->product_entry_calls;
	}

	/**
	 * Get calls to get_product_variation_entries().
	 *
	 * @return WC_Product[] Products passed to get_product_variation_entries().
	 */
	public function get_product_variation_entry_calls(): array {

		return $this->variation_entry_calls;
	}
}
