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

	// Load models.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/models/class-shurloc-mesh-specification.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/models/class-shurloc-catalog-variation-entry.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/models/class-shurloc-catalog-product-entry.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/models/class-shurloc-mesh-product-result.php';

	// Load parsers.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/parsers/class-shurloc-mesh-parser.php';

	// Load analyzers.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/analyzers/class-shurloc-catalog-analyzer.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/analyzers/class-shurloc-mesh-product-analyzer.php';

	// Load services.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/services/class-shurloc-product-catalog-service.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/services/class-shurloc-mesh-product-schema-service.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/services/class-shurloc-product-schema-service.php';

	// Load generators.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/generators/class-shurloc-product-schema-generator.php';

	// Load reports.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/reports/class-shurloc-catalog-report.php';

	// Load integrations.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/integrations/class-shurloc-product-schema-output.php';

	// Load admin integrations.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/admin/catalog-report.php';

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

	$product_schema_output = new Shurloc_Product_Schema_Output(
		$catalog_service,
		$product_schema_service
	);

	/*
	 * Register frontend integrations.
	 */

	add_action(
		'wp_head',
		array(
			$product_schema_output,
			'output',
		),
		20
	);
}

add_action(
	'plugins_loaded',
	'shurloc_product_tools_bootstrap'
);
