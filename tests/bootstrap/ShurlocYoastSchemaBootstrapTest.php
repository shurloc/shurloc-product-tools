<?php
/**
 * Tests Yoast schema integration bootstrap.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests Yoast schema integration loading.
 */
final class ShurlocYoastSchemaBootstrapTest extends TestCase {

	/**
	 * Yoast schema integration should be instantiable.
	 *
	 * @return void
	 */
	public function test_yoast_schema_integration_can_be_instantiated(): void {

		$integration = new Shurloc_Yoast_Schema_Integration();

		$this->assertInstanceOf(
			Shurloc_Yoast_Schema_Integration::class,
			$integration
		);
	}
}
