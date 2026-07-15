<?php
/**
 * Product catalog service.
 *
 * Converts WooCommerce products into catalog entries.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Product catalog service.
 */
final class Shurloc_Product_Catalog_Service implements Shurloc_Product_Catalog_Service_Interface {

	/**
	 * Collect a product catalog entry.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return Shurloc_Catalog_Product_Entry
	 */
	public function get_product_entry(
		WC_Product $product
	): Shurloc_Catalog_Product_Entry {

		$variations = $this->get_product_variation_entries(
			$product
		);

		return new Shurloc_Catalog_Product_Entry(
			(int) $product->get_id(),
			$product->get_name(),
			(string) get_edit_post_link(
				$product->get_id(),
				''
			),
			(string) get_permalink(
				$product->get_id()
			),
			(string) $product->get_sku(),
			$this->get_product_image_url(
				$product
			),
			$this->normalize_price(
				$product->get_price()
			),
			$this->normalize_price(
				$product->get_regular_price()
			),
			$this->normalize_price(
				$product->get_sale_price()
			),
			$this->get_availability(
				$product
			),
			$variations
		);
	}

	/**
	 * Collect variation entries for a variable product.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return Shurloc_Catalog_Variation_Entry[]
	 */
	public function get_product_variation_entries(
		WC_Product $product
	): array {

		if ( ! $product->is_type( 'variable' ) ) {
			return array();
		}

		$entries = array();

		foreach ( $product->get_children() as $variation_id ) {

			$variation = wc_get_product( $variation_id );

			if ( ! $variation ) {
				continue;
			}

			$attributes = $variation->get_variation_attributes();

			if ( 1 !== count( $attributes ) ) {
				continue;
			}

			$entries[] = new Shurloc_Catalog_Variation_Entry(
				array_values( $attributes )[0],
				$this->normalize_price(
					$variation->get_price()
				),
				(int) $product->get_id(),
				$product->get_name(),
				(string) get_edit_post_link(
					$product->get_id(),
					''
				)
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
	 * Get product image URL.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return string|null
	 */
	private function get_product_image_url(
		WC_Product $product
	): ?string {

		$image_id = $product->get_image_id();

		if ( ! $image_id ) {
			return null;
		}

		$image_url = wp_get_attachment_image_url(
			$image_id,
			'full'
		);

		if ( false === $image_url ) {
			return null;
		}

		return $image_url;
	}

	/**
	 * Get product availability.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return string
	 */
	private function get_availability(
		WC_Product $product
	): string {

		if ( $product->is_in_stock() ) {
			return 'https://schema.org/InStock';
		}

		return 'https://schema.org/OutOfStock';
	}

	/**
	 * Normalize a WooCommerce price.
	 *
	 * WooCommerce returns an empty string when no price has been set.
	 *
	 * @param string $price WooCommerce price.
	 * @return float|null
	 */
	private function normalize_price(
		string $price
	): ?float {

		if ( '' === $price ) {
			return null;
		}

		return (float) $price;
	}
}
