<?php
/**
 * Mesh specification model.
 *
 * Represents a parsed mesh specification from a WooCommerce variation.
 *
 * @package ShurLocProductTools
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mesh specification.
 */
class Shurloc_MeshSpecification {

	/**
	 * Original, unmodified variation string.
	 *
	 * @var string
	 */
	public string $raw = '';

	/**
	 * Pack size.
	 *
	 * Examples: "5 Pack", "10 Pack".
	 *
	 * @var string|null
	 */
	public ?string $pack_size = null;

	/**
	 * Mesh count.
	 *
	 * @var int|null
	 */
	public ?int $mesh_count = null;

	/**
	 * Thread diameter.
	 *
	 * @var int|null
	 */
	public ?int $thread_diameter = null;

	/**
	 * Thread modifier.
	 *
	 * Examples: S, M, HD.
	 *
	 * @var string|null
	 */
	public ?string $modifier = null;

	/**
	 * Mesh color.
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
	 * - $23.75
	 * - ($98.55)
	 *
	 * @var string|null
	 */
	public ?string $price_text = null;

	/**
	 * Unknown tokens encountered during parsing.
	 *
	 * @var string[]
	 */
	public array $unknown_tokens = array();
}
