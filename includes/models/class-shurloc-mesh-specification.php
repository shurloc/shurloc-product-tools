<?php
/**
 * Mesh specification model.
 *
 * Represents a parsed mesh specification from a WooCommerce variation.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh specification.
 */
final class Shurloc_Mesh_Specification {

	/**
	 * Original, unmodified variation string.
	 *
	 * Includes price token.
	 *
	 * Examples:
	 * - "60/120 White $18.71"
	 * - "350/30 (s) Yellow $35.27"
	 *
	 * @var string
	 */
	private readonly string $raw;

	/**
	 * Pack size.
	 *
	 * Examples:
	 * - "5 Pack"
	 * - "10 Pack".
	 *
	 * @var string|null
	 */
	private readonly ?string $pack_size;

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
	private readonly ?int $mesh_count;

	/**
	 * Thread diameter.
	 *
	 * Examples:
	 * - 71
	 * - 40
	 *
	 * @var int|null
	 */
	private readonly ?int $thread_diameter;

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
	private readonly ?string $modifier;

	/**
	 * Mesh color.
	 *
	 * Examples:
	 * - "Yellow"
	 * - "White"
	 *
	 * @var string|null
	 */
	private readonly ?string $color;

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
	private readonly ?string $price_text;

	/**
	 * The spec string is recognized as a mesh variation.
	 *
	 * @var bool
	 */
	private readonly bool $recognized;

	/**
	 * Unknown tokens encountered during parsing.
	 *
	 * Example:
	 * - ["Orange", "LD"]
	 *
	 * @var string[]
	 */
	private readonly array $unknown_tokens;


	/**
	 * Constructor.
	 *
	 * @param string      $raw              Original variation string.
	 * @param int|null    $mesh_count       Mesh count.
	 * @param int|null    $thread_diameter  Thread diameter.
	 * @param string|null $modifier      Thread modifier.
	 * @param string|null $color         Mesh color.
	 * @param string|null $pack_size     Pack size.
	 * @param string|null $price_text    Price token.
	 * @param bool        $recognized       Whether specification was recognized.
	 * @param string[]    $unknown_tokens   Unknown tokens.
	 */
	public function __construct(
		string $raw,
		?int $mesh_count,
		?int $thread_diameter,
		?string $modifier,
		?string $color,
		?string $pack_size,
		?string $price_text,
		bool $recognized,
		array $unknown_tokens = array()
	) {

		$this->raw             = $raw;
		$this->mesh_count      = $mesh_count;
		$this->thread_diameter = $thread_diameter;
		$this->modifier        = $modifier;
		$this->color           = $color;
		$this->pack_size       = $pack_size;
		$this->price_text      = $price_text;
		$this->recognized      = $recognized;
		$this->unknown_tokens  = $unknown_tokens;
	}


	/**
	 * Get original variation string.
	 *
	 * @return string Raw variation.
	 */
	public function get_raw(): string {

		return $this->raw;
	}


	/**
	 * Get pack size.
	 *
	 * @return string|null Pack size.
	 */
	public function get_pack_size(): ?string {

		return $this->pack_size;
	}


	/**
	 * Get mesh count.
	 *
	 * @return int|null Mesh count.
	 */
	public function get_mesh_count(): ?int {

		return $this->mesh_count;
	}


	/**
	 * Get thread diameter.
	 *
	 * @return int|null Thread diameter.
	 */
	public function get_thread_diameter(): ?int {

		return $this->thread_diameter;
	}


	/**
	 * Get modifier.
	 *
	 * @return string|null Modifier.
	 */
	public function get_modifier(): ?string {

		return $this->modifier;
	}


	/**
	 * Get color.
	 *
	 * @return string|null Color.
	 */
	public function get_color(): ?string {

		return $this->color;
	}


	/**
	 * Get price text.
	 *
	 * @return string|null Price token.
	 */
	public function get_price_text(): ?string {

		return $this->price_text;
	}


	/**
	 * Determine whether specification was recognized.
	 *
	 * @return bool True if recognized.
	 */
	public function is_recognized(): bool {

		return $this->recognized;
	}


	/**
	 * Get unknown tokens.
	 *
	 * @return string[] Unknown tokens.
	 */
	public function get_unknown_tokens(): array {

		return $this->unknown_tokens;
	}


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
	public function equals(
		Shurloc_Mesh_Specification $other
	): bool {

		return (
			$this->mesh_count === $other->mesh_count &&
			$this->thread_diameter === $other->thread_diameter &&
			$this->modifier === $other->modifier &&
			$this->color === $other->color &&
			$this->pack_size === $other->pack_size &&
			$this->price_text === $other->price_text &&
			$this->recognized === $other->recognized &&
			$this->unknown_tokens === $other->unknown_tokens
		);
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
