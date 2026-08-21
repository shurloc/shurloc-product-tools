<?php
/**
 * Autoloader test interface fixture.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

/**
 * Test interface loaded by autoloader.
 */
interface Shurloc_Test_Service_Interface {

	/**
	 * Return fixture value.
	 *
	 * @return string
	 */
	public function value(): string;
}
