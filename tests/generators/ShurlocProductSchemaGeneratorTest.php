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
	 * A mesh product should generate an offer for each mesh variation.
	 */
	public function test_generates_product_schema_with_multiple_offers(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_mesh_variation(
			new Shurloc_Catalog_Variation_Entry(
				'110/80 Yellow $20.00',
				20.0,
				123,
				'Test Mesh Product',
				''
			),
			$this->create_spec(
				110,
				80,
				'Yellow'
			)
		);

		$result->add_mesh_variation(
			new Shurloc_Catalog_Variation_Entry(
				'160/64 White $25.00',
				25.0,
				123,
				'Test Mesh Product',
				''
			),
			$this->create_spec(
				160,
				64,
				'White'
			)
		);

		$generator = new Shurloc_Product_Schema_Generator();

		$schema = $generator->generate(
			'Test Mesh Product',
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

		$this->assertCount(
			2,
			$schema['offers']
		);
	}


	/**
	 * Offers should contain variation pricing.
	 */
	public function test_offer_contains_price_information(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_mesh_variation(
			new Shurloc_Catalog_Variation_Entry(
				'110/80 Yellow $20.00',
				20.0,
				123,
				'Test Mesh Product',
				''
			),
			$this->create_spec(
				110,
				80,
				'Yellow'
			)
		);

		$generator = new Shurloc_Product_Schema_Generator();

		$schema = $generator->generate(
			'Test Mesh Product',
			$result
		);

		$offer = $schema['offers'][0];

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
			new Shurloc_Catalog_Variation_Entry(
				'110/80 Yellow $20.00',
				20.0,
				123,
				'Test Mesh Product',
				''
			),
			$this->create_spec(
				110,
				80,
				'Yellow'
			)
		);

		$generator = new Shurloc_Product_Schema_Generator();

		$schema = $generator->generate(
			'Test Mesh Product',
			$result
		);

		$properties = $schema['offers'][0]['additionalProperty'];

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
	 * An empty mesh result should generate no offers.
	 */
	public function test_empty_result_generates_empty_offers(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$generator = new Shurloc_Product_Schema_Generator();

		$schema = $generator->generate(
			'Test Mesh Product',
			$result
		);

		$this->assertArrayHasKey(
			'offers',
			$schema
		);

		$this->assertCount(
			0,
			$schema['offers']
		);
	}

	/**
	 * Duplicate mesh specifications should remain separate offers.
	 *
	 * Duplicate specifications are valid when they represent separate
	 * catalog variations with different prices.
	 */
	public function test_duplicate_specifications_generate_separate_offers(): void {

		$result = new Shurloc_Mesh_Product_Result();

		$result->add_mesh_variation(
			new Shurloc_Catalog_Variation_Entry(
				'110/80 Yellow $20.00',
				20.0,
				123,
				'Test Mesh Product',
				''
			),
			$this->create_spec(
				110,
				80,
				'Yellow'
			)
		);

		$result->add_mesh_variation(
			new Shurloc_Catalog_Variation_Entry(
				'110/80 Yellow $25.00',
				25.0,
				123,
				'Test Mesh Product',
				''
			),
			$this->create_spec(
				110,
				80,
				'Yellow'
			)
		);

		$generator = new Shurloc_Product_Schema_Generator();

		$schema = $generator->generate(
			'Test Mesh Product',
			$result
		);

		$this->assertCount(
			2,
			$schema['offers'],
			'Each catalog variation should generate its own offer.'
		);

		$this->assertSame(
			'20.00',
			$schema['offers'][0]['price']
		);

		$this->assertSame(
			'25.00',
			$schema['offers'][1]['price']
		);
	}

	/**
	 * Create a mesh specification fixture.
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
