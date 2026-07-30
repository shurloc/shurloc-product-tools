<?php
/**
 * Tests for the catalog analysis service.
 *
 * @package ShurLocProductTools\Tests
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests for Shurloc_Catalog_Analysis_Service.
 */
final class ShurlocCatalogAnalysisServiceTest extends TestCase {

	/**
	 * WooCommerce product.
	 *
	 * @var WC_Product
	 */
	private WC_Product $product;

	/**
	 * Catalog variation entries.
	 *
	 * @var Shurloc_Catalog_Variation_Entry[]
	 */
	private array $variation_entries;


	/**
	 * Set up each test.
	 *
	 * @return void
	 */
	protected function setUp(): void {

		parent::setUp();

		$this->product = new WC_Product( 101 );

		$this->variation_entries = array(
			new Shurloc_Catalog_Variation_Entry(
				variation: '160/64 Yellow $14.99',
				price: 14.99,
				product_id: 101,
				product_name: 'Test Product',
				edit_url: '',
			),
			new Shurloc_Catalog_Variation_Entry(
				variation: '110/80 White $12.99',
				price: 12.99,
				product_id: 101,
				product_name: 'Test Product',
				edit_url: '',
			),
			new Shurloc_Catalog_Variation_Entry(
				variation: '60/120 White $10.99',
				price: 10.99,
				product_id: 101,
				product_name: 'Test Product',
				edit_url: '',
			),
		);

		$GLOBALS['shurloc_test_product_ids'] = array(
			101,
		);

		$GLOBALS['shurloc_test_products'] = array(
			101 => $this->product,
		);
	}


	/**
	 * Reset test globals.
	 *
	 * @return void
	 */
	protected function tearDown(): void {

		$GLOBALS['shurloc_test_product_ids'] = array();
		$GLOBALS['shurloc_test_products']    = array();

		parent::tearDown();
	}


	/**
	 * It collects and naturally sorts catalog variation entries.
	 *
	 * @return void
	 */
	public function test_it_collects_and_sorts_catalog_variation_entries(): void {

		$catalog_service = new Shurloc_Product_Catalog_Service_Double(
			variation_entries: $this->variation_entries,
		);

		$service = $this->create_service(
			catalog_service: $catalog_service,
		);

		$entries = $service->get_variation_entries();

		$calls = $catalog_service->get_product_variation_entry_calls();

		$this->assertCount( 3, $entries );

		$this->assertSame(
			'60/120 White $10.99',
			$entries[0]->variation
		);

		$this->assertSame(
			'110/80 White $12.99',
			$entries[1]->variation
		);

		$this->assertSame(
			'160/64 Yellow $14.99',
			$entries[2]->variation
		);

		$this->assertCount( 1, $calls );
		$this->assertSame( $this->product, $calls[0] );
	}


	/**
	 * It returns only the naturally sorted variation values.
	 *
	 * @return void
	 */
	public function test_it_returns_catalog_variation_values(): void {

		$service = $this->create_service();

		$values = $service->get_variation_values();

		$this->assertSame(
			array(
				'60/120 White $10.99',
				'110/80 White $12.99',
				'160/64 Yellow $14.99',
			),
			$values
		);
	}


	/**
	 * Create the service under test.
	 *
	 * @param Shurloc_Product_Catalog_Service_Interface|null $catalog_service Catalog service override.
	 * @return Shurloc_Catalog_Analysis_Service
	 */
	private function create_service(
		?Shurloc_Product_Catalog_Service_Interface $catalog_service = null
	): Shurloc_Catalog_Analysis_Service {

		return new Shurloc_Catalog_Analysis_Service(
			catalog_service: $catalog_service ?? new Shurloc_Product_Catalog_Service_Double(
				variation_entries: $this->variation_entries,
			),
			analyzer: new Shurloc_Catalog_Analyzer(
				parser: new Shurloc_Mesh_Parser(),
			),
		);
	}
}
