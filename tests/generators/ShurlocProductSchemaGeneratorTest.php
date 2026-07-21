<?php
/**
 * Tests for Shurloc_Product_Schema_Generator.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests product schema generation.
 */
final class ShurlocProductSchemaGeneratorTest extends TestCase {

	/**
	 * A mesh product should generate an aggregate offer with multiple variations.
	 */
	public function test_generates_product_schema_with_aggregate_offer(): void {

		$result = $this->create_mesh_result();

		$schema = $this->generate_schema(
			$result
		);

		$this->assertSame(
			'https://schema.org',
			$schema['@context']
		);

		$this->assertSame(
			'Product',
			$schema['@type']
		);

		$this->assertSame(
			'Test Mesh Product',
			$schema['name']
		);

		$this->assertSame(
			'https://example.com/product/test-mesh-product/#product',
			$schema['@id']
		);

		$this->assertSame(
			'https://example.com/product/test-mesh-product/',
			$schema['url']
		);

		$this->assertSame(
			'TEST-MESH-123',
			$schema['sku']
		);

		$this->assertSame(
			'https://example.com/image.jpg',
			$schema['image']
		);

		$this->assertSame(
			'Brand',
			$schema['brand']['@type']
		);

		$this->assertSame(
			'Test Brand',
			$schema['brand']['name']
		);

		$this->assertSame(
			'Organization',
			$schema['manufacturer']['@type']
		);

		$this->assertSame(
			'Shur-loc',
			$schema['manufacturer']['name']
		);

		$this->assertSame(
			'AggregateRating',
			$schema['aggregateRating']['@type']
		);

		$this->assertSame(
			'5',
			$schema['aggregateRating']['ratingValue']
		);

		$this->assertSame(
			'12',
			$schema['aggregateRating']['reviewCount']
		);

		$this->assertCount(
			1,
			$schema['review']
		);

		$this->assertSame(
			'Review',
			$schema['review'][0]['@type']
		);

		$this->assertSame(
			'AggregateOffer',
			$schema['offers']['@type']
		);

		$this->assertSame(
			'20.00',
			$schema['offers']['lowPrice']
		);

		$this->assertSame(
			'25.00',
			$schema['offers']['highPrice']
		);

		$this->assertSame(
			2,
			$schema['offers']['offerCount']
		);

		$this->assertCount(
			2,
			$schema['offers']['offers']
		);
	}

	/**
	 * Product schema should include brand information.
	 */
	public function test_product_schema_includes_brand(): void {

		$schema = $this->generate_schema(
			$this->create_mesh_result()
		);

		$this->assertSame(
			'Brand',
			$schema['brand']['@type']
		);

		$this->assertSame(
			'Test Brand',
			$schema['brand']['name']
		);
	}

	/**
	 * Product schema should include manufacturer information.
	 */
	public function test_product_schema_includes_manufacturer(): void {

		$schema = $this->generate_schema(
			$this->create_mesh_result()
		);

		$this->assertSame(
			'Organization',
			$schema['manufacturer']['@type']
		);

		$this->assertSame(
			'Shur-loc',
			$schema['manufacturer']['name']
		);
	}

	/**
	 * Product schema should include aggregate rating when provided.
	 */
	public function test_product_schema_includes_aggregate_rating_when_present(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			123,
			'Rated Product',
			'',
			'https://example.com/product/rated-product/',
			'RATED-123',
			null,
			25.0,
			25.0,
			null,
			'https://schema.org/InStock',
			'Test Brand',
			'Shur-loc',
			array(
				'@type'       => 'AggregateRating',
				'ratingValue' => '4.8',
				'reviewCount' => 12,
			),
			array(),
			array()
		);

		$schema = ( new Shurloc_Product_Schema_Generator() )->generate(
			$product,
			new Shurloc_Mesh_Product_Result()
		);

		$this->assertArrayHasKey(
			'aggregateRating',
			$schema
		);

		$this->assertSame(
			'AggregateRating',
			$schema['aggregateRating']['@type']
		);

		$this->assertSame(
			'4.8',
			$schema['aggregateRating']['ratingValue']
		);

		$this->assertSame(
			12,
			$schema['aggregateRating']['reviewCount']
		);
	}

	/**
	 * Product schema should include reviews when provided.
	 */
	public function test_product_schema_includes_reviews_when_present(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			123,
			'Reviewed Product',
			'',
			'https://example.com/product/reviewed-product/',
			'REVIEW-123',
			null,
			25.0,
			25.0,
			null,
			'https://schema.org/InStock',
			'Test Brand',
			'Shur-loc',
			null,
			array(
				array(
					'@type'        => 'Review',
					'author'       => array(
						'@type' => 'Person',
						'name'  => 'John Smith',
					),
					'reviewRating' => array(
						'@type'       => 'Rating',
						'ratingValue' => '5',
					),
					'reviewBody'   => 'Excellent product quality.',
				),
			),
			array()
		);

		$schema = ( new Shurloc_Product_Schema_Generator() )->generate(
			$product,
			new Shurloc_Mesh_Product_Result()
		);

		$this->assertArrayHasKey(
			'review',
			$schema
		);

		$this->assertCount(
			1,
			$schema['review']
		);

		$this->assertSame(
			'Review',
			$schema['review'][0]['@type']
		);

		$this->assertSame(
			'John Smith',
			$schema['review'][0]['author']['name']
		);

		$this->assertSame(
			'5',
			$schema['review'][0]['reviewRating']['ratingValue']
		);
	}

	/**
	 * Product schema should not include rating or reviews when none exist.
	 */
	public function test_product_schema_excludes_rating_and_reviews_when_missing(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			123,
			'Unreviewed Product',
			'',
			'https://example.com/product/unreviewed-product/',
			'UNREVIEWED-123',
			null,
			25.0,
			25.0,
			null,
			'https://schema.org/InStock',
			'Test Brand',
			'Shur-loc',
			null,
			array(),
			array()
		);

		$schema = ( new Shurloc_Product_Schema_Generator() )->generate(
			$product,
			new Shurloc_Mesh_Product_Result()
		);

		$this->assertArrayNotHasKey(
			'aggregateRating',
			$schema
		);

		$this->assertArrayNotHasKey(
			'review',
			$schema
		);
	}

	/**
	 * Aggregate offers should contain pricing range.
	 */
	public function test_aggregate_offer_contains_price_range(): void {

		$schema = $this->generate_schema(
			$this->create_mesh_result()
		);

		$offers = $schema['offers'];

		$this->assertSame(
			'AggregateOffer',
			$offers['@type']
		);

		$this->assertSame(
			'20.00',
			$offers['lowPrice']
		);

		$this->assertSame(
			'25.00',
			$offers['highPrice']
		);

		$this->assertSame(
			2,
			$offers['offerCount']
		);

		$this->assertSame(
			'USD',
			$offers['priceCurrency']
		);
	}

	/**
	 * Offers should contain variation pricing.
	 */
	public function test_offer_contains_price_information(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_mesh_variation(
			$this->create_variation(
				'110/80 Yellow $20.00',
				20.0
			),
			$this->create_spec(
				110,
				80,
				'Yellow'
			)
		);

		$schema = $this->generate_schema(
			$result
		);

		$offer = $schema['offers']['offers'][0];

		$this->assertSame(
			'Offer',
			$offer['@type']
		);

		$this->assertSame(
			'20.00',
			$offer['price']
		);

		$this->assertSame(
			'USD',
			$offer['priceCurrency']
		);
	}

	/**
	 * Mesh specifications should be included as properties.
	 */
	public function test_offer_contains_mesh_properties(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_mesh_variation(
			$this->create_variation(
				'110/80 Yellow $20.00',
				20.0
			),
			$this->create_spec(
				110,
				80,
				'Yellow'
			)
		);

		$schema = $this->generate_schema(
			$result
		);

		$properties = $schema['offers']['offers'][0]['additionalProperty'];

		$this->assertSame(
			'Mesh Count',
			$properties[0]['name']
		);

		$this->assertSame(
			110,
			$properties[0]['value']
		);

		$this->assertSame(
			'Thread Diameter',
			$properties[1]['name']
		);

		$this->assertSame(
			80,
			$properties[1]['value']
		);

		$this->assertSame(
			'Yellow',
			$properties[2]['value']
		);
	}

	/**
	 * An empty mesh result should not generate offers when product has no price.
	 */
	public function test_empty_result_does_not_generate_offers(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			123,
			'Empty Product',
			'',
			'https://example.com/product/empty-product/',
			'EMPTY-123',
			null,
			null,
			null,
			null,
			'https://schema.org/InStock',
			null,
			'Shur-loc',
			null,
			array(),
			array()
		);

		$schema = ( new Shurloc_Product_Schema_Generator() )->generate(
			$product,
			new Shurloc_Mesh_Product_Result()
		);

		$this->assertArrayNotHasKey(
			'offers',
			$schema
		);
	}

	/**
	 * Duplicate mesh specifications should remain separate offers.
	 */
	public function test_duplicate_specifications_generate_separate_offers(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_mesh_variation(
			$this->create_variation(
				'110/80 Yellow $20.00',
				20.0
			),
			$this->create_spec(
				110,
				80,
				'Yellow'
			)
		);

		$result->add_mesh_variation(
			$this->create_variation(
				'110/80 Yellow $25.00',
				25.0
			),
			$this->create_spec(
				110,
				80,
				'Yellow'
			)
		);

		$schema = $this->generate_schema(
			$result
		);

		$this->assertCount(
			2,
			$schema['offers']['offers']
		);

		$this->assertSame(
			'20.00',
			$schema['offers']['offers'][0]['price']
		);

		$this->assertSame(
			'25.00',
			$schema['offers']['offers'][1]['price']
		);
	}

	/**
	 * Non-mesh products should generate a simple offer.
	 */
	public function test_non_mesh_product_generates_simple_offer(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			456,
			'Non Mesh Product',
			'',
			'https://example.com/product/non-mesh-product/',
			'NON-MESH-456',
			'https://example.com/non-mesh-image.jpg',
			50.0,
			50.0,
			null,
			'https://schema.org/InStock',
			'Test Brand',
			'Shur-loc',
			null,
			array(),
			array()
		);

		$schema = ( new Shurloc_Product_Schema_Generator() )->generate(
			$product,
			new Shurloc_Mesh_Product_Result()
		);

		$this->assertSame(
			'Offer',
			$schema['offers']['@type']
		);

		$this->assertSame(
			'50.00',
			$schema['offers']['price']
		);

		$this->assertSame(
			'https://schema.org/InStock',
			$schema['offers']['availability']
		);

		$this->assertSame(
			'https://example.com/product/non-mesh-product/',
			$schema['offers']['url']
		);
	}

	/**
	 * Products without variations should still generate an offer.
	 */
	public function test_product_without_variations_can_generate_offer(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			789,
			'Simple Product',
			'',
			'https://example.com/product/simple-product/',
			'SIMPLE-789',
			null,
			15.0,
			15.0,
			null,
			'https://schema.org/InStock',
			'Test Brand',
			'Shur-loc',
			null,
			array(),
			array()
		);

		$schema = ( new Shurloc_Product_Schema_Generator() )->generate(
			$product,
			new Shurloc_Mesh_Product_Result()
		);

		$this->assertSame(
			'15.00',
			$schema['offers']['price']
		);
	}

	/**
	 * Product schema should not include empty image values.
	 *
	 * @return void
	 */
	public function test_empty_image_is_not_added_to_schema(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			123,
			'No Image Product',
			'',
			'https://example.com/product/no-image/',
			'NO-IMAGE-123',
			null,
			25.0,
			25.0,
			null,
			'https://schema.org/InStock',
			'Test Brand',
			'Shur-loc',
			null,
			array(),
			array()
		);

		$schema = ( new Shurloc_Product_Schema_Generator() )->generate(
			$product,
			new Shurloc_Mesh_Product_Result()
		);

		$this->assertArrayNotHasKey(
			'image',
			$schema
		);
	}

	/**
	 * Sale price should be used for simple product offers.
	 */
	public function test_sale_price_is_used_for_offer_price(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			100,
			'Sale Product',
			'',
			'https://example.com/product/sale-product/',
			'SALE-100',
			null,
			10.0,
			20.0,
			10.0,
			'https://schema.org/InStock',
			'Test Brand',
			'Shur-loc',
			null,
			array(),
			array()
		);

		$schema = ( new Shurloc_Product_Schema_Generator() )->generate(
			$product,
			new Shurloc_Mesh_Product_Result()
		);

		$this->assertSame(
			'Offer',
			$schema['offers']['@type']
		);

		$this->assertSame(
			'10.00',
			$schema['offers']['price']
		);
	}

	/**
	 * Product availability should be included in generated offers.
	 */
	public function test_offer_preserves_product_availability(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			101,
			'Availability Product',
			'',
			'https://example.com/product/availability-product/',
			'AVAILABLE-101',
			null,
			25.0,
			25.0,
			null,
			'https://schema.org/OutOfStock',
			'Test Brand',
			'Shur-loc',
			null,
			array(),
			array()
		);

		$schema = ( new Shurloc_Product_Schema_Generator() )->generate(
			$product,
			new Shurloc_Mesh_Product_Result()
		);

		$this->assertSame(
			'https://schema.org/OutOfStock',
			$schema['offers']['availability']
		);
	}

	/**
	 * Products with a current price should use that price for offers.
	 *
	 * @return void
	 */
	public function test_current_price_is_used_for_offer_price(): void {

		$product = new Shurloc_Catalog_Product_Entry(
			789,
			'Current Price Product',
			'',
			'https://example.com/product/current-price/',
			'CURRENT-789',
			null,
			30.0,
			40.0,
			30.0,
			'https://schema.org/InStock',
			'Test Brand',
			'Shur-loc',
			null,
			array(),
			array()
		);

		$schema = ( new Shurloc_Product_Schema_Generator() )->generate(
			$product,
			new Shurloc_Mesh_Product_Result()
		);

		$this->assertSame(
			'30.00',
			$schema['offers']['price']
		);
	}

	/**
	 * Create mesh result fixture.
	 *
	 * @return Shurloc_Mesh_Product_Result
	 */
	private function create_mesh_result(): Shurloc_Mesh_Product_Result {

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_mesh_variation(
			$this->create_variation(
				'110/80 Yellow $20.00',
				20.0
			),
			$this->create_spec(
				110,
				80,
				'Yellow'
			)
		);

		$result->add_mesh_variation(
			$this->create_variation(
				'160/64 White $25.00',
				25.0
			),
			$this->create_spec(
				160,
				64,
				'White'
			)
		);

		return $result;
	}

	/**
	 * Generate schema.
	 *
	 * @param Shurloc_Mesh_Product_Result $result Mesh result.
	 * @return array<string,mixed>
	 */
	private function generate_schema(
		Shurloc_Mesh_Product_Result $result
	): array {

		return ( new Shurloc_Product_Schema_Generator() )->generate(
			$this->create_product_entry(),
			$result
		);
	}

	/**
	 * Create product fixture.
	 *
	 * @return Shurloc_Catalog_Product_Entry
	 */
	private function create_product_entry(): Shurloc_Catalog_Product_Entry {

		return new Shurloc_Catalog_Product_Entry(
			123,
			'Test Mesh Product',
			'',
			'https://example.com/product/test-mesh-product/',
			'TEST-MESH-123',
			'https://example.com/image.jpg',
			null,
			null,
			null,
			'https://schema.org/InStock',
			'Test Brand',
			'Shur-loc',
			array(
				'@type'       => 'AggregateRating',
				'ratingValue' => '5',
				'reviewCount' => '12',
				'bestRating'  => '5',
				'worstRating' => '1',
			),
			array(
				array(
					'@type'        => 'Review',
					'reviewRating' => array(
						'@type'       => 'Rating',
						'ratingValue' => '5',
						'bestRating'  => '5',
					),
					'author'       => array(
						'@type' => 'Person',
						'name'  => 'Test Customer',
					),
					'reviewBody'   => 'Excellent product quality.',
				),
			),
			array()
		);
	}

	/**
	 * Create variation fixture.
	 *
	 * @param string $variation Variation text.
	 * @param float  $price Variation price.
	 * @return Shurloc_Catalog_Variation_Entry
	 */
	private function create_variation(
		string $variation,
		float $price
	): Shurloc_Catalog_Variation_Entry {

		return new Shurloc_Catalog_Variation_Entry(
			$variation,
			$price,
			123,
			'Test Mesh Product',
			''
		);
	}

	/**
	 * Create mesh specification fixture.
	 *
	 * @param int    $mesh_count       Mesh count.
	 * @param int    $thread_diameter  Thread diameter.
	 * @param string $color            Color.
	 * @param string $modifier         Optional modifier.
	 * @param string $pack_size        Optional pack size.
	 * @param string $price_text       Price text.
	 * @return Shurloc_Mesh_Specification
	 */
	private function create_spec(
		int $mesh_count,
		int $thread_diameter,
		string $color,
		?string $modifier = null,
		?string $pack_size = null,
		string $price_text = '$20.00'
	): Shurloc_Mesh_Specification {

		return new Shurloc_Mesh_Specification(
			$mesh_count . '/' . $thread_diameter . ' ' . $color . ' ' . $price_text,
			$mesh_count,
			$thread_diameter,
			$modifier,
			$color,
			$pack_size,
			$price_text,
			true,
			array()
		);
	}
}
