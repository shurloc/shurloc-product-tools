<?php
/**
 * Tests for the mesh parser.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProviderExternal;

/**
 * Mesh parser tests.
 */
class ShurlocMeshParserTest extends TestCase {

	/**
	 * Verify the raw input string is preserved.
	 */
	public function test_raw_string_is_preserved(): void {

		$parser = new Shurloc_Mesh_Parser();

		$spec = $parser->parse(
			'110/80 Yellow $23.75'
		);

		$this->assertSame(
			'110/80 Yellow $23.75',
			$spec->raw
		);
	}

	/**
	 * Verify that standard mesh specifications are parsed correctly.
	 *
	 * @param string                     $input The raw variation string.
	 * @param Shurloc_Mesh_Specification $expected The expected spec after parsing.
	 */
	#[DataProviderExternal(
		MeshParserDataProvider::class,
		'standard_mesh'
	)]
	public function test_parses_standard_mesh(
		string $input,
		Shurloc_Mesh_Specification $expected
	): void {

		$parser = new Shurloc_Mesh_Parser();

		$actual = $parser->parse( $input );

		$this->assertEquals(
			$expected,
			$actual
		);
	}

	/**
	 * Verify that standard mesh specifications is recognized correctly.
	 *
	 * @param string $variation The raw variation string.
	 */
	#[DataProviderExternal(
		MeshParserDataProvider::class,
		'recognized_mesh'
	)]
	public function test_recognizes_mesh_specifications(
		string $variation
	): void {

		$parser = new Shurloc_Mesh_Parser();

		$spec = $parser->parse( $variation );

		$this->assertTrue( $spec->recognized );
	}

	/**
	 * Verify that non-standard specifications is unrecognized correctly.
	 *
	 * @param string $variation The raw variation string.
	 */
	#[DataProviderExternal(
		MeshParserDataProvider::class,
		'unrecognized_variations'
	)]
	public function test_rejects_non_mesh_specifications(
		string $variation
	): void {

		$parser = new Shurloc_Mesh_Parser();

		$spec = $parser->parse( $variation );

		$this->assertFalse( $spec->recognized );
	}
}
