<?php
/**
 * Plugin bootstrap.
 *
 * Loads and initializes the Shur-Loc Product Tools plugin.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bootstrap the plugin.
 */
function shurloc_product_tools_bootstrap(): void {
	/*
	 * Autoloader.
	 */

	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/class-shurloc-autoloader.php';

	$autoloader = new Shurloc_Autoloader(
		__DIR__
	);

	$autoloader->register();

	/*
	 * Build application services.
	 */

	$catalog_service = new Shurloc_Product_Catalog_Service();

	$mesh_analyzer = new Shurloc_Mesh_Product_Analyzer(
		new Shurloc_Mesh_Parser()
	);

	$mesh_data_service = new Shurloc_Mesh_Product_Data_Service(
		$catalog_service,
		$mesh_analyzer
	);

	$mesh_schema_service = new Shurloc_Mesh_Product_Schema_Service(
		$mesh_analyzer
	);

	$schema_generator = new Shurloc_Product_Schema_Generator();

	$product_schema_service = new Shurloc_Product_Schema_Service(
		$schema_generator,
		$mesh_schema_service
	);

	$schema_renderer = new Shurloc_Product_Schema_Renderer();

	$product_schema_integration = new Shurloc_Product_Schema_Integration(
		$catalog_service,
		$product_schema_service,
		$schema_renderer
	);

	$woocommerce_schema_integration = new Shurloc_WooCommerce_Schema_Integration();

	$mesh_parser = new Shurloc_Mesh_Parser();

	$catalog_analyzer = new Shurloc_Catalog_Analyzer(
		mesh_parser: $mesh_parser
	);

	$analysis_service = new Shurloc_Catalog_Analysis_Service(
		catalog_service: $catalog_service,
		catalog_analyzer: $catalog_analyzer,
	);

	$catalog_report_controller = new Shurloc_Catalog_Report_Controller(
		catalog_service: $catalog_service,
		analysis_service: $analysis_service,
	);

	$request_handler = new Shurloc_Catalog_Report_Request_Handler(
		$catalog_report_controller
	);

	/*
	 * Mesh table presentation pipeline.
	 */

	$mesh_table_data_factory = new Shurloc_Mesh_Table_Data_Factory();

	$mesh_table_renderer = new Shurloc_Mesh_Product_Table_Renderer();

	$mesh_table_shortcode = new Shurloc_Mesh_Product_Table_Shortcode(
		$mesh_data_service,
		$mesh_table_data_factory,
		$mesh_table_renderer
	);

	$mesh_table_assets = new Shurloc_Mesh_Product_Table_Assets(
		SHURLOC_PRODUCT_TOOLS_URL,
		SHURLOC_PRODUCT_TOOLS_VERSION
	);

	$mesh_table_tab = new Shurloc_Mesh_Product_Table_Tab(
		$mesh_table_shortcode
	);

	/*
	 * Register frontend integrations.
	 */

	$product_schema_integration->register();

	add_action(
		'init',
		function () use ( $woocommerce_schema_integration ): void {

			if ( class_exists( 'WooCommerce' ) ) {

				$woocommerce_schema_integration->register();

			}
		},
		20
	);

	$catalog_report_controller->register();

	$mesh_table_shortcode->register();

	$mesh_table_assets->register();

	$mesh_table_tab->register();

	$product_breadcrumbs = new Shurloc_Product_Breadcrumbs();
	$product_breadcrumbs->register();

	$breadcrumb_schema = new Shurloc_Breadcrumb_Schema();
	$breadcrumb_schema->register();

	$breadcrumb_separator = new Shurloc_Breadcrumb_Separator();
	$breadcrumb_separator->register();

	$recommendation_eligibility = new Shurloc_Product_Recommendation_Eligibility_Service();

	$related_products = new Shurloc_Related_Products(
		$recommendation_eligibility
	);
	$related_products->register();

	$dynamic_cross_sells = new Shurloc_Dynamic_Cross_Sells(
		$recommendation_eligibility
	);
	$dynamic_cross_sells->register();
}

add_action(
	'plugins_loaded',
	'shurloc_product_tools_bootstrap'
);
