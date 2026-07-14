<?php
/**
 * Product schema generator.
 *
 * Generates Schema.org Product structured data from mesh product analysis
 * results.
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

		$offers = array();

		foreach ( $result->mesh_variations as $variation ) {

			$entry = $variation['entry'];
			$spec  = $variation['spec'];

			$offers[] = array(
				'@type'              => 'Offer',
				'price'              => number_format(
					$entry->price,
					2,
					'.',
					''
				),
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
		}

		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Product',
			'@id'      => $product->product_url . '#product',
			'name'     => $product->product_name,
			'url'      => $product->product_url,
		);

		if ( ! empty( $offers ) ) {

			$schema['offers'] = $this->build_aggregate_offer(
				$offers
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
	 * Build aggregate offer data.
	 *
	 * This method assumes at least one offer exists.
	 *
	 * @param array<int,array<string,mixed>> $offers Product offers.
	 * @return array<string,mixed>
	 */
	private function build_aggregate_offer(
		array $offers
	): array {

		$prices = array();

		foreach ( $offers as $offer ) {

			$prices[] = (float) $offer['price'];
		}

		return array(
			'@type'         => 'AggregateOffer',
			'lowPrice'      => number_format(
				min( $prices ),
				2,
				'.',
				''
			),
			'highPrice'     => number_format(
				max( $prices ),
				2,
				'.',
				''
			),
			'offerCount'    => count( $offers ),
			'priceCurrency' => 'USD',
			'availability'  => 'https://schema.org/InStock',
			'offers'        => $offers,
		);
	}
}
