<?php
/**
 * Product catalog service.
 *
 * Converts WooCommerce products into catalog variation entries.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Product catalog service.
 */
final class Shurloc_Product_Catalog_Service {

	/**
	 * Collect variation entries for a variable product.
	 *
	 * @param WC_Product $product WooCommerce product.
	 * @return Shurloc_Catalog_Variation_Entry[]
	 */
	public function get_variation_entries(
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
