<?php
/**
 * Product schema service test double.
 *
 * Provides a controllable implementation of the product schema service
 * interface for testing consumers that generate product schema data.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Product schema service test double.
 */
final class Shurloc_Product_Schema_Service_Double implements Shurloc_Product_Schema_Service_Interface {

	/**
	 * Schema returned by the double.
	 *
	 * @var array<string,mixed>|null
	 */
	private ?array $schema;

	/**
	 * Calls to generate().
	 *
	 * @var Shurloc_Catalog_Product_Entry[]
	 */
	private array $calls = array();

	/**
	 * Constructor.
	 *
	 * @param array<string,mixed>|null $schema Schema to return.
	 */
	public function __construct(
		?array $schema = null
	) {

		$this->schema = $schema;
	}

	/**
	 * Generate product schema.
	 *
	 * Records the supplied product and returns the configured schema.
	 *
	 * @param Shurloc_Catalog_Product_Entry $product Catalog product.
	 * @return array<string,mixed>|null Product schema or null.
	 */
	public function generate(
		Shurloc_Catalog_Product_Entry $product
	): ?array {

		$this->calls[] = $product;

		return $this->schema;
	}

	/**
	 * Get calls to generate().
	 *
	 * @return Shurloc_Catalog_Product_Entry[] Products passed to generate().
	 */
	public function get_calls(): array {

		return $this->calls;
	}
}
