<?php
/**
 * Tests catalog report generation.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests catalog report generation.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class ShurlocCatalogReportIntegrationTest extends TestCase {

	/**
	 * Test catalog report generation from fixture data.
	 *
	 * @return void
	 * @throws JsonException    If the fixture JSON is invalid.
	 * @throws RuntimeException If the fixture cannot be read.
	 */
	public function test_generates_catalog_report(): void {

		$entries = MeshCatalogDataProvider::load_catalog();

		$parser = new Shurloc_Mesh_Parser();

		$analyzer = new Shurloc_Catalog_Analyzer(
			$parser
		);

		$report = $analyzer->analyze(
			$entries
		);

		$this->assertInstanceOf(
			Shurloc_Catalog_Report::class,
			$report
		);

		$data = $report->to_array();

		$this->assertArrayHasKey(
			'recognized_specifications',
			$data
		);

		$this->assertArrayHasKey(
			'unrecognized_variations',
			$data
		);

		$this->assertArrayHasKey(
			'invalid_specifications',
			$data
		);
	}

	/**
	 * Test catalog fixture produces entries.
	 *
	 * Ensures the fixture pipeline is working before analysis.
	 *
	 * @return void
	 * @throws JsonException    If the fixture JSON is invalid.
	 * @throws RuntimeException If the fixture cannot be read.
	 */
	public function test_catalog_fixture_loads_entries(): void {

		$entries = MeshCatalogDataProvider::load_catalog();

		$this->assertNotEmpty(
			$entries
		);

		$this->assertContainsOnlyInstancesOf(
			Shurloc_Catalog_Variation_Entry::class,
			$entries
		);
	}

	/**
	 * Test report recognizes known mesh specification.
	 *
	 * @return void
	 * @throws JsonException    If the fixture JSON is invalid.
	 * @throws RuntimeException If the fixture cannot be read.
	 */
	public function test_report_identifies_known_mesh_specifications(): void {

		$entries = MeshCatalogDataProvider::load_catalog();

		$parser = new Shurloc_Mesh_Parser();

		$analyzer = new Shurloc_Catalog_Analyzer(
			$parser
		);

		$report = $analyzer->analyze(
			$entries
		);

		$data = $report->to_array();

		$recognized_specifications = array_column(
			$data['recognized_specifications'],
			'variation'
		);

		$this->assertContains(
			'123/70 Yellow $19.26',
			$recognized_specifications
		);
	}

	/**
	 * Test report identifies unknown catalog variations.
	 *
	 * @return void
	 * @throws JsonException    If the fixture JSON is invalid.
	 * @throws RuntimeException If the fixture cannot be read.
	 */
	public function test_report_handles_unknown_variations(): void {

		$entries = MeshCatalogDataProvider::load_catalog();

		$entries[] = new Shurloc_Catalog_Variation_Entry(
			'Custom Promotional Product',
			null,
			999999,
			'Fixture Product',
			''
		);

		$parser = new Shurloc_Mesh_Parser();

		$analyzer = new Shurloc_Catalog_Analyzer(
			$parser
		);

		$report = $analyzer->analyze(
			$entries
		);

		$data = $report->to_array();

		$unrecognized_variations = array_column(
			$data['unrecognized_variations'],
			'variation'
		);

		$this->assertContains(
			'Custom Promotional Product',
			$unrecognized_variations
		);

		$this->assertNotContains(
			'Custom Promotional Product',
			$data['recognized_specifications']
		);
	}
}
