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
	 * @param string                      $product_name Product name.
	 * @param Shurloc_Mesh_Product_Result $result      Mesh analysis result.
	 * @return array<string, mixed>
	 */
	public function generate(
		string $product_name,
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

		return array(
			'@context' => 'https://schema.org',
			'@type'    => 'Product',
			'name'     => $product_name,
			'offers'   => $offers,
		);
	}
}
