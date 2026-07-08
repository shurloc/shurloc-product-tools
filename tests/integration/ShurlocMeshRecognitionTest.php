<?php
/**
 * Integration tests for mesh recognition.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

/**
 * Integration tests using the exported WooCommerce catalog.
 */
final class ShurlocMeshRecognitionTest extends TestCase {

	/**
	 * Catalog variations are loaded successfully.
	 *
	 * @param string $variation Variation name.
	 */
	#[DataProviderExternal(
		MeshCatalogDataProvider::class,
		'catalog_variations'
	)]
	public function test_catalog_fixture_loads(
		string $variation
	): void {

		$this->assertNotSame( '', $variation );
	}
}
