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
	 * It classifies every variation as recognized, unrecognized, or invalid.
	 */
	public function test_catalog_recognition(): void {

		$parser = new Shurloc_Mesh_Parser();

		$catalog = MeshCatalogDataProvider::load_catalog();

		$recognized   = array();
		$unrecognized = array();
		$invalid      = array();

		foreach ( $catalog as $variation ) {

			$spec = $parser->parse( $variation );

			if ( ! $spec->recognized ) {
				$unrecognized[] = $variation;
				continue;
			}

			$recognized[] = $variation;

			if ( ! $spec->is_valid() ) {
				$invalid[] = array(
					'variation'      => $variation,
					'unknown_tokens' => $spec->unknown_tokens,
				);
			}
		}

		// Sanity checks.
		$this->assertNotEmpty(
			$catalog,
			'Catalog fixture appears to be empty.'
		);

		$this->assertNotEmpty(
			$recognized,
			'No catalog variations were recognized.'
		);

		// TODO:
		// Export the recognized, unrecognized, and invalid arrays as a JSON
		// report for inspection during parser development.
	}
}
