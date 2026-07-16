<?php
/**
 * Product schema generator.
 *
 * Generates Schema.org Product structured data from product catalog data
 * and mesh product analysis results.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Product schema generator.
 */
final class Shurloc_Product_Schema_Generator {

	/**
	 * Generate Product schema data.
	 *
	 * @param Shurloc_Catalog_Product_Entry $product Product catalog entry.
	 * @param Shurloc_Mesh_Product_Result   $result  Mesh analysis result.
	 * @return array<string, mixed>
	 */
	public function generate(
		Shurloc_Catalog_Product_Entry $product,
		Shurloc_Mesh_Product_Result $result
	): array {

		$mesh_offers = array();

		foreach ( $result->mesh_variations as $variation ) {

			$entry = $variation['entry'];
			$spec  = $variation['spec'];

			$mesh_offer = array(
				'@type'              => 'Offer',
				'priceCurrency'      => 'USD',
				'availability'       => 'https://schema.org/InStock',
				'name'               => $entry->variation,
				'additionalProperty' => array(
					array(
						'@type' => 'PropertyValue',
						'name'  => 'Mesh Count',
						'value' => $spec->mesh_count,
					),
					array(
						'@type' => 'PropertyValue',
						'name'  => 'Thread Diameter',
						'value' => $spec->thread_diameter,
					),
					array(
						'@type' => 'PropertyValue',
						'name'  => 'Color',
						'value' => $spec->color,
					),
				),
			);

			$price = $this->format_price(
				$entry->price
			);

			if ( null !== $price ) {
				$mesh_offer['price'] = $price;
			}

			$mesh_offers[] = $mesh_offer;
		}

		$schema = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'Product',
			'@id'              => $product->product_url . '#product',
			'name'             => $product->product_name,
			'url'              => $product->product_url,
			'mainEntityOfPage' => array(
				'@id' => $product->product_url,
			),
		);

		/*
		 * Add brand information.
		 */
		if ( null !== $product->brand ) {

			$schema['brand'] = array(
				'@type' => 'Brand',
				'name'  => $product->brand,
			);
		}

		/*
		 * Add manufacturer information.
		 */
		$schema['manufacturer'] = array(
			'@type' => 'Organization',
			'name'  => $product->manufacturer,
		);

		/*
		 * Add aggregate rating when reviews exist.
		 */
		if ( null !== $product->aggregate_rating ) {

			$schema['aggregateRating'] = $product->aggregate_rating;
		}

		/*
		 * Add reviews when available.
		 */
		if ( ! empty( $product->reviews ) ) {

			$schema['review'] = $product->reviews;
		}

		if ( ! empty( $mesh_offers ) ) {

			$schema['offers'] = $this->build_aggregate_offer(
				$mesh_offers
			);

		} elseif ( null !== $product->price ) {

			$schema['offers'] = $this->build_product_offer(
				$product
			);
		}

		if ( '' !== $product->sku ) {
			$schema['sku'] = $product->sku;
		}

		if ( null !== $product->image_url ) {
			$schema['image'] = $product->image_url;
		}

		return $schema;
	}

	/**
	 * Build simple product offer data.
	 *
	 * @param Shurloc_Catalog_Product_Entry $product Product catalog entry.
	 * @return array<string,mixed>
	 */
	private function build_product_offer(
		Shurloc_Catalog_Product_Entry $product
	): array {

		$offer = array(
			'@type'         => 'Offer',
			'priceCurrency' => 'USD',
			'availability'  => $product->availability,
			'url'           => $product->product_url,
		);

		$price = $this->format_price(
			$product->price
		);

		if ( null !== $price ) {
			$offer['price'] = $price;
		}

		return $offer;
	}

	/**
	 * Build aggregate offer data.
	 *
	 * @param array<int,array<string,mixed>> $offers Product offers.
	 * @return array<string,mixed>
	 */
	private function build_aggregate_offer(
		array $offers
	): array {

		$prices = array();

		foreach ( $offers as $offer ) {

			if (
				isset( $offer['price'] )
				&& is_numeric( $offer['price'] )
			) {
				$prices[] = (float) $offer['price'];
			}
		}

		$aggregate_offer = array(
			'@type'         => 'AggregateOffer',
			'offerCount'    => count( $offers ),
			'priceCurrency' => 'USD',
			'availability'  => 'https://schema.org/InStock',
			'offers'        => $offers,
		);

		if ( ! empty( $prices ) ) {

			$aggregate_offer['lowPrice'] = $this->format_price(
				min( $prices )
			);

			$aggregate_offer['highPrice'] = $this->format_price(
				max( $prices )
			);
		}

		return $aggregate_offer;
	}

	/**
	 * Format a price for schema output.
	 *
	 * @param float|null $price Price value.
	 * @return string|null
	 */
	private function format_price(
		?float $price
	): ?string {

		if ( null === $price ) {
			return null;
		}

		return number_format(
			$price,
			2,
			'.',
			''
		);
	}
}
