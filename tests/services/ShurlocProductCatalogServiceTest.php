<?php
/**
 * Tests for Shurloc_Product_Catalog_Service.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests product catalog service.
 */
final class ShurlocProductCatalogServiceTest extends TestCase {

	/**
	 * Product catalog service instance.
	 *
	 * @var Shurloc_Product_Catalog_Service
	 */
	private Shurloc_Product_Catalog_Service $service;

	/**
	 * Setup tests.
	 *
	 * @return void
	 */
	protected function setUp(): void {

		$this->service = new Shurloc_Product_Catalog_Service();
	}

	/**
	 * Simple product should create catalog entry.
	 *
	 * @return void
	 */
	public function test_simple_product_creates_catalog_entry(): void {

		$product = new WC_Product( 123 );

		$product->set_name(
			'Test Product'
		);

		$product->set_sku(
			'TEST-123'
		);

		$product->set_short_description(
			'Test short description.'
		);

		$product->set_description(
			'Test full description.'
		);

		$product->set_category(
			'Screen Printing'
		);

		$product->set_price(
			'25.00'
		);

		$product->set_regular_price(
			'30.00'
		);

		$product->set_sale_price(
			'25.00'
		);

		$product->set_stock_status(
			'instock'
		);

		wp_set_object_terms(
			123,
			array( 'Screen Printing' ),
			'product_cat'
		);

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertInstanceOf(
			Shurloc_Catalog_Product_Entry::class,
			$entry
		);

		$this->assertSame(
			123,
			$entry->product_id
		);

		$this->assertSame(
			'Test Product',
			$entry->product_name
		);

		$this->assertSame(
			'TEST-123',
			$entry->sku
		);

		$this->assertSame(
			'Test short description.',
			$entry->short_description
		);

		$this->assertSame(
			'Test full description.',
			$entry->description
		);

		$this->assertSame(
			'Screen Printing',
			$entry->category
		);

		$this->assertSame(
			25.0,
			$entry->price
		);

		$this->assertSame(
			30.0,
			$entry->regular_price
		);

		$this->assertSame(
			25.0,
			$entry->sale_price
		);

		$this->assertSame(
			'https://schema.org/InStock',
			$entry->availability
		);
	}

	/**
	 * Product should default manufacturer to Shur-loc.
	 *
	 * @return void
	 */
	public function test_product_manufacturer_defaults_to_shurloc(): void {

		$product = new WC_Product( 456 );

		$product->set_name(
			'Manufacturer Test'
		);

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertSame(
			'Shur-loc®',
			$entry->manufacturer
		);
	}

	/**
	 * Product brand should be loaded from product data.
	 *
	 * @return void
	 */
	public function test_product_brand_is_loaded(): void {

		$product = new WC_Product( 789 );

		$product->set_name(
			'Branded Product'
		);

		wp_set_object_terms(
			789,
			array( 'Murakami' ),
			'product_brand'
		);

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertSame(
			'Murakami',
			$entry->brand
		);
	}

	/**
	 * Product without brand should default to Shur-loc.
	 *
	 * @return void
	 */
	public function test_product_without_brand_defaults_to_shurloc(): void {

		$product = new WC_Product( 999 );

		$product->set_name(
			'No Brand Product'
		);

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertSame(
			'Shur-loc®',
			$entry->brand
		);
	}

	/**
	 * Product without reviews should have no aggregate rating.
	 *
	 * @return void
	 */
	public function test_product_without_reviews_has_no_rating_data(): void {

		$product = new WC_Product( 1000 );

		$product->set_name(
			'No Review Product'
		);

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertNull(
			$entry->aggregate_rating
		);

		$this->assertSame(
			array(),
			$entry->reviews
		);
	}

	/**
	 * Out of stock products should preserve availability.
	 *
	 * @return void
	 */
	public function test_out_of_stock_product_sets_availability(): void {

		$product = new WC_Product( 111 );

		$product->set_stock_status(
			'outofstock'
		);

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertSame(
			'https://schema.org/OutOfStock',
			$entry->availability
		);
	}

	/**
	 * Empty WooCommerce prices should normalize to null.
	 *
	 * @return void
	 */
	public function test_empty_prices_are_normalized_to_null(): void {

		$product = new WC_Product( 222 );

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertNull(
			$entry->price
		);

		$this->assertNull(
			$entry->regular_price
		);

		$this->assertNull(
			$entry->sale_price
		);
	}

	/**
	 * Variable product returns variations.
	 *
	 * @return void
	 */
	public function test_variable_product_returns_variations(): void {

		$product = new WC_Product( 200 );

		$product->set_name(
			'Variable Product'
		);

		$product->set_type(
			'variable'
		);

		$product->set_children(
			array(
				201,
			)
		);

		$variation = new WC_Product_Variation( 201 );

		$variation->set_variation_attributes(
			array(
				'attribute_select-mesh-count' => '110/80 Yellow',
			)
		);

		$GLOBALS['shurloc_test_products'][201] = $variation;

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertCount(
			1,
			$entry->variations
		);
	}

	/**
	 * Product descriptions should remove HTML tags.
	 *
	 * @return void
	 */
	public function test_product_descriptions_are_stripped_of_html(): void {

		$product = new WC_Product( 400 );

		$product->set_name(
			'HTML Product'
		);

		$product->set_short_description(
			'<p>Short <strong>description</strong></p>'
		);

		$product->set_description(
			'<div>Full <em>description</em></div>'
		);

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertSame(
			'Short description',
			$entry->short_description
		);

		$this->assertSame(
			'Full description',
			$entry->description
		);
	}

	/**
	 * Mesh variation data should survive catalog conversion.
	 *
	 * @return void
	 */
	public function test_mesh_variation_data_survives_catalog_conversion(): void {

		$product = new WC_Product( 500 );

		$product->set_name(
			'Mesh Product'
		);

		$product->set_type(
			'variable'
		);

		$product->set_children(
			array(
				501,
			)
		);

		$variation = new WC_Product_Variation( 501 );

		$variation->set_variation_attributes(
			array(
				'attribute_select-mesh-count' => '160/64 White',
			)
		);

		$variation->set_price(
			'25.00'
		);

		$GLOBALS['shurloc_test_products'][501] = $variation;

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertSame(
			'160/64 White',
			$entry->variations[0]->variation
		);

		$this->assertSame(
			25.0,
			$entry->variations[0]->price
		);
	}

	/**
	 * Mesh variation attribute values are preserved.
	 *
	 * @return void
	 */
	public function test_mesh_variation_attribute_value_is_preserved(): void {

		$product = new WC_Product( 300 );

		$product->set_name(
			'Mesh Product'
		);

		$product->set_type(
			'variable'
		);

		$product->set_children(
			array(
				301,
			)
		);

		$variation = new WC_Product_Variation( 301 );

		$variation->set_variation_attributes(
			array(
				'attribute_select-mesh-count' => '160/64 White',
			)
		);

		$GLOBALS['shurloc_test_products'][301] = $variation;

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertSame(
			'160/64 White',
			$entry->variations[0]->variation
		);
	}

	/**
	 * Variations without attributes are ignored.
	 *
	 * @return void
	 */
	public function test_variations_without_attributes_are_ignored(): void {

		$product = new WC_Product( 400 );

		$product->set_type(
			'variable'
		);

		$product->set_children(
			array(
				401,
			)
		);

		$variation = new WC_Product_Variation( 401 );

		$GLOBALS['shurloc_test_products'][401] = $variation;

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertCount(
			0,
			$entry->variations
		);
	}

	/**
	 * Variations are sorted naturally.
	 *
	 * @return void
	 */
	public function test_variations_are_sorted_naturally(): void {

		$product = new WC_Product( 500 );

		$product->set_type(
			'variable'
		);

		$product->set_children(
			array(
				501,
				502,
			)
		);

		$first = new WC_Product_Variation( 501 );

		$first->set_variation_attributes(
			array(
				'attribute_select-mesh-count' => '160/64 White',
			)
		);

		$second = new WC_Product_Variation( 502 );

		$second->set_variation_attributes(
			array(
				'attribute_select-mesh-count' => '110/80 Yellow',
			)
		);

		$GLOBALS['shurloc_test_products'][501] = $first;
		$GLOBALS['shurloc_test_products'][502] = $second;

		$entry = $this->service->get_product_entry(
			$product
		);

		$this->assertSame(
			'110/80 Yellow',
			$entry->variations[0]->variation
		);

		$this->assertSame(
			'160/64 White',
			$entry->variations[1]->variation
		);
	}
}
