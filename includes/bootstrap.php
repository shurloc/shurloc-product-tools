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
		plugin_dir_path( __FILE__ ) . 'includes'
	);

	$autoloader->register();

	/*
	 * Build application services.
	 */

	$catalog_service = new Shurloc_Product_Catalog_Service();

	$mesh_analyzer = new Shurloc_Mesh_Product_Analyzer(
		new Shurloc_Mesh_Parser()
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

	/*
	 * Load admin integrations.
	 */
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/admin/catalog-report.php';
}

add_action(
	'plugins_loaded',
	'shurloc_product_tools_bootstrap'
);
