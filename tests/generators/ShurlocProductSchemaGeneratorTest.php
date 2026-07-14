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
	 * @param int    $mesh_count Mesh count.
	 * @param int    $thread_diameter Thread diameter.
	 * @param string $color Color.
	 * @return Shurloc_Mesh_Specification
	 */
	private function create_spec(
		int $mesh_count,
		int $thread_diameter,
		string $color
	): Shurloc_Mesh_Specification {

		$spec = new Shurloc_Mesh_Specification();

		$spec->recognized      = true;
		$spec->mesh_count      = $mesh_count;
		$spec->thread_diameter = $thread_diameter;
		$spec->color           = $color;
		$spec->price_text      = '$20.00';

		return $spec;
	}
}
