<?php
/**
 * Tests for the mesh specification model.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Mesh specification tests.
 */
final class ShurlocMeshSpecificationTest extends TestCase {

	/**
	 * Verify that equals() returns true for identical specifications.
	 */
	public function test_equals_returns_true_for_identical_specs(): void {

		$spec_a = $this->create_spec();
		$spec_b = $this->create_spec();

		$this->assertTrue(
			$spec_a->equals( $spec_b )
		);
	}

	/**
	 * Verify that equals() returns false when the mesh count differs.
	 */
	public function test_equals_returns_false_for_different_mesh_count(): void {

		$spec_a = $this->create_spec();

		$spec_b             = $this->create_spec();
		$spec_b->mesh_count = 160;

		$this->assertFalse(
			$spec_a->equals( $spec_b )
		);
	}

	/**
	 * Verify that equals() returns false when the thread diameter differs.
	 */
	public function test_equals_returns_false_for_different_thread_diameter(): void {

		$spec_a = $this->create_spec();

		$spec_b                  = $this->create_spec();
		$spec_b->thread_diameter = 64;

		$this->assertFalse(
			$spec_a->equals( $spec_b )
		);
	}

	/**
	 * Verify that equals() returns false when the modifier differs.
	 */
	public function test_equals_returns_false_for_different_modifier(): void {

		$spec_a = $this->create_spec();

		$spec_b           = $this->create_spec();
		$spec_b->modifier = 'HD';

		$this->assertFalse(
			$spec_a->equals( $spec_b )
		);
	}

	/**
	 * Verify that equals() returns false when the color differs.
	 */
	public function test_equals_returns_false_for_different_color(): void {

		$spec_a = $this->create_spec();

		$spec_b        = $this->create_spec();
		$spec_b->color = 'White';

		$this->assertFalse(
			$spec_a->equals( $spec_b )
		);
	}
	/**
	 * Verify that equals() returns false when the pack size differs.
	 */
	public function test_equals_returns_false_for_different_pack_size(): void {

		$spec_a = $this->create_spec();

		$spec_b            = $this->create_spec();
		$spec_b->pack_size = '20 Pack';

		$this->assertFalse(
			$spec_a->equals( $spec_b )
		);
	}

	/**
	 * Verify that equals() returns false when the price differs.
	 */
	public function test_equals_returns_false_for_different_price_text(): void {

		$spec_a = $this->create_spec();

		$spec_b             = $this->create_spec();
		$spec_b->price_text = '$25.00';

		$this->assertFalse(
			$spec_a->equals( $spec_b )
		);
	}

	/**
	 * Verify that equals() returns false when unknown tokens differ.
	 */
	public function test_equals_returns_false_for_different_unknown_tokens(): void {

		$spec_a = $this->create_spec();

		$spec_b                 = $this->create_spec();
		$spec_b->unknown_tokens = array(
			'Thin Thread',
		);

		$this->assertFalse(
			$spec_a->equals( $spec_b )
		);
	}

	/**
	 * Verify that is_valid() returns true for a complete specification.
	 */
	public function test_is_valid_returns_true_for_complete_spec(): void {

		$spec = $this->create_spec();

		$this->assertTrue(
			$spec->is_valid()
		);
	}

	/**
	 * Verify that is_valid() returns false when the mesh count is missing.
	 */
	public function test_is_valid_returns_false_for_missing_mesh_count(): void {

		$spec             = $this->create_spec();
		$spec->mesh_count = null;

		$this->assertFalse(
			$spec->is_valid()
		);
	}

	/**
	 * Verify that is_valid() returns false when the thread diameter is missing.
	 */
	public function test_is_valid_returns_false_for_missing_thread_diameter(): void {

		$spec                  = $this->create_spec();
		$spec->thread_diameter = null;

		$this->assertFalse(
			$spec->is_valid()
		);
	}

	/**
	 * Create specification fixture.
	 *
	 * @return Shurloc_Mesh_Specification
	 */
	private function create_spec(): Shurloc_Mesh_Specification {

		$spec = new Shurloc_Mesh_Specification();

		$spec->recognized      = true;
		$spec->mesh_count      = 110;
		$spec->thread_diameter = 80;
		$spec->modifier        = null;
		$spec->color           = 'Yellow';
		$spec->pack_size       = '10 Pack';
		$spec->price_text      = '$20.00';
		$spec->unknown_tokens  = array();

		return $spec;
	}
}
