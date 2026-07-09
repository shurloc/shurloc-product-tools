<?php
/**
 * Integration tests for mesh recognition.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Integration tests using the exported WooCommerce catalog.
 */
final class ShurlocMeshRecognitionTest extends TestCase {

	/**
	 * Parse every variation in the exported catalog.
	 *
	 * This test exercises the parser against a real-world catalog snapshot.
	 */
	public function test_analyzes_catalog_fixture(): void {

		$catalog = MeshCatalogDataProvider::load_catalog();

		$analyzer = new Shurloc_Catalog_Analyzer(
			new Shurloc_Mesh_Parser()
		);

		$report = $analyzer->analyze( $catalog );

		// Sanity checks.
		$this->assertNotEmpty(
			$catalog,
			'Catalog fixture appears to be empty.'
		);

		$this->assertInstanceOf(
			Shurloc_Catalog_Report::class,
			$report
		);

		$this->assertNotEmpty(
			$report->recognized_specifications,
			'No catalog variations were recognized.'
		);

		$this->assertSame(
			count( $catalog ),
			count( $report->recognized_specifications ) +
			count( $report->unrecognized_variations ),
			'Every catalog variation should be classified.'
		);

		// TODO:
		// Export $report as JSON for inspection during parser development.
	}
}
