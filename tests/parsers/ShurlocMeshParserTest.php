<?php
/**
 * Tests for the mesh parser.
 *
 * @package ShurLocProductTools
 */

use PHPUnit\Framework\TestCase;

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
}
