<?php
/**
 * Tests Yoast schema integration.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests Yoast schema modifications.
 */
final class ShurlocYoastSchemaIntegrationTest extends TestCase {

	/**
	 * Product schema should be removed from Yoast output.
	 *
	 * @return void
	 */
	public function test_removes_yoast_product_schema(): void {

		$schema = array(
			array(
				'@type' => 'Organization',
				'name'  => 'Example Company',
			),
			array(
				'@type' => 'Product',
				'name'  => 'Yoast Product',
			),
			array(
				'@type' => 'BreadcrumbList',
			),
		);

		$result = ( new Shurloc_Yoast_Schema_Integration() )->remove_product_schema(
			$schema
		);

		$this->assertCount(
			2,
			$result
		);

		foreach ( $result as $node ) {

			$this->assertNotSame(
				'Product',
				$node['@type'] ?? null
			);
		}
	}

	/**
	 * Non-product schema nodes should be preserved.
	 *
	 * @return void
	 */
	public function test_preserves_non_product_schema_nodes(): void {

		$schema = array(
			array(
				'@type' => 'Organization',
			),
			array(
				'@type' => 'BreadcrumbList',
			),
		);

		$result = ( new Shurloc_Yoast_Schema_Integration() )->remove_product_schema(
			$schema
		);

		$this->assertCount(
			2,
			$result
		);
	}
}
