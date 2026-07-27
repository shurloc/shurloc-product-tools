<?php
/**
 * Mesh product table shortcode.
 *
 * Provides the [shurloc_mesh_table] shortcode.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

/**
 * Mesh product table shortcode.
 */
final class Shurloc_Mesh_Product_Table_Shortcode implements Shurloc_Mesh_Product_Table_Shortcode_Interface {

	/**
	 * Mesh product data service.
	 *
	 * @var Shurloc_Mesh_Product_Data_Service_Interface
	 */
	private Shurloc_Mesh_Product_Data_Service_Interface $data_service;

	/**
	 * Mesh table data factory.
	 *
	 * @var Shurloc_Mesh_Table_Data_Factory
	 */
	private Shurloc_Mesh_Table_Data_Factory $table_data_factory;

	/**
	 * Mesh product table renderer.
	 *
	 * @var Shurloc_Mesh_Product_Table_Renderer_Interface
	 */
	private Shurloc_Mesh_Product_Table_Renderer_Interface $renderer;

	/**
	 * Constructor.
	 *
	 * @param Shurloc_Mesh_Product_Data_Service_Interface   $data_service       Mesh product data service.
	 * @param Shurloc_Mesh_Table_Data_Factory               $table_data_factory Mesh table data factory.
	 * @param Shurloc_Mesh_Product_Table_Renderer_Interface $renderer           Table renderer.
	 */
	public function __construct(
		Shurloc_Mesh_Product_Data_Service_Interface $data_service,
		Shurloc_Mesh_Table_Data_Factory $table_data_factory,
		Shurloc_Mesh_Product_Table_Renderer_Interface $renderer
	) {

		$this->data_service       = $data_service;
		$this->table_data_factory = $table_data_factory;
		$this->renderer           = $renderer;
	}

	/**
	 * Register shortcode.
	 *
	 * @return void
	 */
	public function register(): void {

		add_shortcode(
			'shurloc_mesh_table',
			array(
				$this,
				'render',
			)
		);
	}

	/**
	 * Render shortcode.
	 *
	 * @param array<string,mixed> $attributes Shortcode attributes.
	 * @return string
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found, Squiz.Commenting.FunctionComment.Missing
	public function render(
		array $attributes = array()
	): string {

		global $product;

		if ( ! $product instanceof WC_Product ) {
			return '';
		}

		$result = $this->data_service->analyze_product(
			$product
		);

		if ( null === $result || ! $result->is_mesh_product() ) {
			return '';
		}

		$data = $this->table_data_factory->create(
			$result
		);

		if ( ! $data->has_rows() ) {
			return '';
		}

		wp_enqueue_style(
			Shurloc_Mesh_Product_Table_Assets::STYLE_HANDLE
		);

		return $this->renderer->render(
			$data
		);
	}
}
