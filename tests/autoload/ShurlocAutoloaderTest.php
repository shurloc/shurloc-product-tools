<?php
/**
 * Tests for plugin autoloader.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests Shurloc autoloader behavior.
 */
final class ShurlocAutoloaderTest extends TestCase {

	/**
	 * Autoloader should load classes from fixture directories.
	 *
	 * @return void
	 */
	public function test_loads_classes_from_recursive_directories(): void {

		$autoloader = new Shurloc_Autoloader(
			__DIR__ . '/../fixtures/autoload'
		);

		$autoloader->register();

		$this->assertTrue(
			class_exists(
				Shurloc_Test_Model::class
			)
		);

		$model = new Shurloc_Test_Model();

		$this->assertSame(
			'model-loaded',
			$model->value()
		);
	}

	/**
	 * Autoloader should load interfaces.
	 *
	 * @return void
	 */
	public function test_loads_interfaces_without_interface_suffix_in_filename(): void {

		$autoloader = new Shurloc_Autoloader(
			__DIR__ . '/../fixtures/autoload'
		);

		$autoloader->register();

		$this->assertTrue(
			interface_exists(
				Shurloc_Test_Service_Interface::class
			)
		);
	}

	/**
	 * Autoloader should load traits.
	 *
	 * @return void
	 */
	public function test_loads_traits_without_trait_suffix_in_filename(): void {

		$autoloader = new Shurloc_Autoloader(
			__DIR__ . '/../fixtures/autoload'
		);

		$autoloader->register();

		$this->assertTrue(
			trait_exists(
				Shurloc_Test_Helper_Trait::class
			)
		);

		$this->assertTrue(
			in_array(
				Shurloc_Test_Helper_Trait::class,
				get_declared_traits(),
				true
			)
		);
	}
}
