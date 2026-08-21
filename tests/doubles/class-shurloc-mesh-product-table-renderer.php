<?php
/**
 * Mesh product table renderer double.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product table renderer double.
 */
final class Shurloc_Mesh_Product_Table_Renderer_Double implements Shurloc_Mesh_Product_Table_Renderer_Interface {

	/**
	 * Rendered output.
	 *
	 * @var string
	 */
	private string $output;

	/**
	 * Render calls.
	 *
	 * @var Shurloc_Mesh_Table_Data[]
	 */
	private array $calls = array();

	/**
	 * Constructor.
	 *
	 * @param string $output Rendered output.
	 */
	public function __construct(
		string $output
	) {

		$this->output = $output;
	}

	/**
	 * Render mesh table.
	 *
	 * @param Shurloc_Mesh_Table_Data $data Table data.
	 * @return string Rendered HTML.
	 */
	public function render(
		Shurloc_Mesh_Table_Data $data
	): string {

		$this->calls[] = $data;

		return $this->output;
	}

	/**
	 * Get render calls.
	 *
	 * @return Shurloc_Mesh_Table_Data[]
	 */
	public function get_calls(): array {

		return $this->calls;
	}
}
