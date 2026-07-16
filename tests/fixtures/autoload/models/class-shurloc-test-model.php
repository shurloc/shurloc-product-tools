<?php
/**
 * Autoloader test model fixture.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Test model loaded by autoloader.
 */
final class Shurloc_Test_Model {

	/**
	 * Return fixture value.
	 *
	 * @return string
	 */
	public function value(): string {

		return 'model-loaded';
	}
}
