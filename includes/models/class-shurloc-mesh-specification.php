<?php
/**
 * Mesh specification model.
 *
 * Represents a parsed mesh specification from a WooCommerce variation.
 *
 * @package ShurLocProductTools
 */

/**
 * Mesh specification.
 */
class Shurloc_Mesh_Specification {

	/**
	 * Original, unmodified variation string.
	 *
	 * Examples:
	 * - "60/120 White $18.71"
	 * - "350/30 (s) Yellow $35.27"
	 *
	 * @var string
	 */
	public string $raw = '';

	/**
	 * Pack size.
	 *
	 * Examples:
	 * - "5 Pack"
	 * - "10 Pack".
	 *
	 * @var string|null
	 */
	public ?string $pack_size = null;

	/**
	 * Mesh count.
	 *
	 * Examples:
	 * - 60
	 * - 110
	 * - 350
	 *
	 * @var int|null
	 */
	public ?int $mesh_count = null;

	/**
	 * Thread diameter.
	 *
	 * Examples:
	 * - 71
	 * - 40
	 *
	 * @var int|null
	 */
	public ?int $thread_diameter = null;

	/**
	 * Thread modifier.
	 *
	 * Examples:
	 * - "S"
	 * - "M"
	 * - "HD"
	 *
	 * @var string|null
	 */
	public ?string $modifier = null;

	/**
	 * Mesh color.
	 *
	 * Examples:
	 * - "Yellow"
	 * - "White"
	 *
	 * @var string|null
	 */
	public ?string $color = null;

	/**
	 * Price text.
	 *
	 * Stored as the original price token extracted from the variation.
	 *
	 * Examples:
	 * - "$23.75"
	 * - "($98.55)"
	 *
	 * @var string|null
	 */
	public ?string $price_text = null;

	/**
	 * Unknown tokens encountered during parsing.
	 *
	 * Example:
	 * - ["Orange", "LD"]
	 *
	 * @var string[]
	 */
	public array $unknown_tokens = array();

	/**
	 * Check to see if this object is valid.
	 */
	public function is_valid(): bool {
		return null !== $this->mesh_count;
	}

	/**
	 * Compare two specifications.
	 *
	 * @param Shurloc_Mesh_Specification $other The spec to compare against this object.
	 * @return bool True if the specs are the same.
	 */
	public function equals( Shurloc_Mesh_Specification $other ): bool {

		return $this->mesh_count === $other->mesh_count
			&& $this->thread_diameter === $other->thread_diameter
			&& $this->modifier === $other->modifier
			&& $this->color === $other->color
			&& $this->pack_size === $other->pack_size
			&& $this->price_text === $other->price_text
			&& $this->unknown_tokens === $other->unknown_tokens;
	}
}
