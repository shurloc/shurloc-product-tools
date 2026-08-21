<?php
/**
 * Mesh product table shortcode double.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product table shortcode double.
 */
final class Shurloc_Mesh_Product_Table_Shortcode_Double implements Shurloc_Mesh_Product_Table_Shortcode_Interface {

	/**
	 * HTML to return.
	 *
	 * @var string
	 */
	public string $html = '';

	/**
	 * Number of render calls.
	 *
	 * @var int
	 */
	public int $render_calls = 0;

	/**
	 * Render shortcode.
	 *
	 * @param array<string,mixed> $attributes Shortcode attributes.
	 * @return string
	 */
	public function render(
		array $attributes = array()
	): string {

		++$this->render_calls;

		return $this->html;
	}
}
