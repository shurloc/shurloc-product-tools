<?php
/**
 * Autoloader test trait fixture.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Test trait loaded by autoloader.
 */
trait Shurloc_Test_Helper_Trait {

	/**
	 * Return fixture value.
	 *
	 * @return string
	 */
	public function helper_value(): string {

		return 'trait-loaded';
	}
}
