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

	// Load service interfaces.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/services/interface-shurloc-product-schema-service.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/services/class-shurloc-product-catalog-service.php';
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/services/interface-shurloc-mesh-product-schema-service.php';

	// Load renderer interfaces.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/renderers/interface-shurloc-product-schema-renderer.php';

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
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/integrations/class-shurloc-product-schema-integration.php';

	// Load renderers.
	require_once SHURLOC_PRODUCT_TOOLS_PATH . 'includes/renderers/class-shurloc-product-schema-renderer.php';

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

	$schema_renderer = new Shurloc_Product_Schema_Renderer();

	$product_schema_integration = new Shurloc_Product_Schema_Integration(
		$catalog_service,
		$product_schema_service,
		$schema_renderer
	);

	/*
	 * Register frontend integrations.
	 */

	$product_schema_integration->register();
}

add_action(
	'plugins_loaded',
	'shurloc_product_tools_bootstrap'
);
