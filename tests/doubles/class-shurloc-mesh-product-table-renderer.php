<?php
/**
 * Mesh product table renderer test double.
 *
 * Records render calls and returns configurable HTML.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product table renderer test double.
 */
final class Shurloc_Mesh_Product_Table_Renderer_Double implements Shurloc_Mesh_Product_Table_Renderer_Interface {

	/**
	 * HTML returned by the renderer.
	 *
	 * @var string
	 */
	private string $html;

	/**
	 * Recorded render calls.
	 *
	 * @var Shurloc_Mesh_Product_Result[]
	 */
	private array $calls = array();

	/**
	 * Constructor.
	 *
	 * @param string $html HTML to return when render() is called.
	 */
	public function __construct(
		string $html = ''
	) {

		$this->html = $html;
	}

	/**
	 * Render the mesh product table.
	 *
	 * Records the supplied analysis result and returns the configured HTML.
	 *
	 * @param Shurloc_Mesh_Product_Result $result Mesh product analysis result.
	 * @return string HTML output.
	 */
	public function render(
		Shurloc_Mesh_Product_Result $result
	): string {

		$this->calls[] = $result;

		return $this->html;
	}

	/**
	 * Return recorded render calls.
	 *
	 * @return Shurloc_Mesh_Product_Result[]
	 */
	public function get_calls(): array {

		return $this->calls;
	}

	/**
	 * Set the HTML returned by render().
	 *
	 * @param string $html HTML output.
	 * @return void
	 */
	public function set_html(
		string $html
	): void {

		$this->html = $html;
	}
}
