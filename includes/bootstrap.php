<?php
/**
 * Plugin bootstrap.
 *
 * Loads and initializes the Shur-loc Product Tools plugin.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Shurloc\Tools\Shurloc_Admin_Page_Interface;

/**
 * Bootstrap the plugin.
 */
function shurloc_product_tools_bootstrap(): void {
	/*
	 * Autoloader.
	 */

	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/class-shurloc-autoloader.php';

	$autoloader = new Shurloc_Autoloader(
		base_directory:__DIR__,
	);

	$autoloader->register();

	/*
	 * Build application services.
	 */

	$mesh_parser = new Shurloc_Mesh_Parser();

	$catalog_service = new Shurloc_Product_Catalog_Service();

	$mesh_analyzer = new Shurloc_Mesh_Product_Analyzer(
		parser: $mesh_parser,
	);

	$mesh_data_service = new Shurloc_Mesh_Product_Data_Service(
		catalog_service: $catalog_service,
		mesh_analyzer: $mesh_analyzer,
	);

	$catalog_analyzer = new Shurloc_Catalog_Analyzer(
		mesh_parser: $mesh_parser,
	);

	$analysis_service = new Shurloc_Catalog_Analysis_Service(
		catalog_service: $catalog_service,
		catalog_analyzer: $catalog_analyzer,
	);

	/**
	 * Schema integrations.
	 */

	$mesh_schema_service = new Shurloc_Mesh_Product_Schema_Service(
		analyzer: $mesh_analyzer,
	);

	$schema_generator = new Shurloc_Product_Schema_Generator();

	$product_schema_service = new Shurloc_Product_Schema_Service(
		generator: $schema_generator,
		mesh_schema_service: $mesh_schema_service,
	);

	$schema_renderer = new Shurloc_Product_Schema_Renderer();

	$product_schema_integration = new Shurloc_Product_Schema_Integration(
		catalog_service: $catalog_service,
		schema_service: $product_schema_service,
		renderer: $schema_renderer,
	);
	$product_schema_integration->register();

	$woocommerce_schema_integration = new Shurloc_WooCommerce_Schema_Integration();
	$woocommerce_schema_integration->register();

	/**
	 * Admin UI and integration.
	 */

	/**
	 * Intelephense false positive.
	 *
	 * @disregard P1009 Undefined type 'Shurloc\Tools\Shurloc_Admin_Page_Interface'. */
	if ( interface_exists( Shurloc_Admin_Page_Interface::class ) ) {
		$catalog_report_controller = new Shurloc_Catalog_Report_Controller(
			catalog_service: $catalog_service,
			analysis_service: $analysis_service,
		);
		$catalog_report_controller->register();

		$admin_menu = new Shurloc_Admin_Menu(
			product_page: $catalog_report_controller,
		);
		$admin_menu->register();

		$request_handler = new Shurloc_Catalog_Report_Request_Handler(
			actions: $catalog_report_controller,
		);
	}

	/*
	 * Mesh table presentation pipeline.
	 */

	$mesh_table_data_factory = new Shurloc_Mesh_Table_Data_Factory();

	$mesh_table_renderer = new Shurloc_Mesh_Product_Table_Renderer();

	$mesh_table_shortcode = new Shurloc_Mesh_Product_Table_Shortcode(
		data_service: $mesh_data_service,
		table_data_factory: $mesh_table_data_factory,
		renderer: $mesh_table_renderer,
	);
	$mesh_table_shortcode->register();

	$mesh_table_assets = new Shurloc_Mesh_Product_Table_Assets(
		asset_url: SHURLOC_PRODUCT_TOOLS_URL,
		asset_version: SHURLOC_PRODUCT_TOOLS_VERSION,
	);
	$mesh_table_assets->register();

	$mesh_table_tab = new Shurloc_Mesh_Product_Table_Tab(
		shortcode: $mesh_table_shortcode,
	);
	$mesh_table_tab->register();

	/**
	 * Frontend integrations.
	 */

	$product_breadcrumbs = new Shurloc_Product_Breadcrumbs();
	$product_breadcrumbs->register();

	$breadcrumb_schema = new Shurloc_Breadcrumb_Schema();
	$breadcrumb_schema->register();

	$breadcrumb_separator = new Shurloc_Breadcrumb_Separator();
	$breadcrumb_separator->register();

	$recommendation_eligibility = new Shurloc_Product_Recommendation_Eligibility_Service();

	$related_products = new Shurloc_Related_Products(
		eligibility: $recommendation_eligibility,
	);
	$related_products->register();

	$dynamic_cross_sells = new Shurloc_Dynamic_Cross_Sells(
		eligibility: $recommendation_eligibility,
	);
	$dynamic_cross_sells->register();
}

add_action(
	'plugins_loaded',
	'shurloc_product_tools_bootstrap',
	20
);
