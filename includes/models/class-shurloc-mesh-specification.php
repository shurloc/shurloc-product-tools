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
	 * The spec string is recognized as a mesh variation.
	 *
	 * @var bool
	 */
	public bool $recognized = false;

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
	 * Determine whether this is a valid mesh specification.
	 *
	 * A specification is considered valid if it was recognized as a mesh
	 * specification, all required fields were parsed successfully, and no
	 * unknown tokens remain.
	 *
	 * @return bool True if the specification is valid; otherwise, false.
	 */
	public function is_valid(): bool {

		return (
			$this->recognized &&
			null !== $this->mesh_count &&
			null !== $this->thread_diameter &&
			null !== $this->color &&
			null !== $this->price_text &&
			empty( $this->unknown_tokens )
		);
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
			&& $this->recognized === $other->recognized
			&& $this->unknown_tokens === $other->unknown_tokens;
	}

	/**
	 * Return the specification as an associative array.
	 *
	 * @return array{
	 *     raw:string,
	 *     mesh_count:int|null,
	 *     thread_diameter:int|null,
	 *     modifier:string|null,
	 *     color:string|null,
	 *     pack_size:string|null,
	 *     price_text:string|null,
	 *     recognized:bool,
	 *     unknown_tokens:string[]
	 * }
	 */
	public function to_array(): array {

		return array(
			'raw'             => $this->raw,
			'mesh_count'      => $this->mesh_count,
			'thread_diameter' => $this->thread_diameter,
			'modifier'        => $this->modifier,
			'color'           => $this->color,
			'pack_size'       => $this->pack_size,
			'price_text'      => $this->price_text,
			'recognized'      => $this->recognized,
			'unknown_tokens'  => $this->unknown_tokens,
		);
	}
}
