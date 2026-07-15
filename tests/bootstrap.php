<?php
/**
 * PHPUnit bootstrap.
 *
 * @package ShurLocProductTools
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __DIR__ ) . DIRECTORY_SEPARATOR );
}

/*
 * Load Composer's autoloader.
 */
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

/*
 * Load service interfaces.
 */
require_once dirname( __DIR__ ) . '/includes/services/interface-shurloc-product-schema-service.php';

/*
 * Load renderer interfaces.
 */
require_once dirname( __DIR__ ) . '/includes/renderers/interface-shurloc-product-schema-renderer.php';

/*
 * Load models.
 */
require_once dirname( __DIR__ ) . '/includes/models/class-shurloc-mesh-specification.php';
require_once dirname( __DIR__ ) . '/includes/models/class-shurloc-catalog-variation-entry.php';
require_once dirname( __DIR__ ) . '/includes/models/class-shurloc-catalog-product-entry.php';
require_once dirname( __DIR__ ) . '/includes/models/class-shurloc-mesh-product-result.php';

/*
 * Load parsers.
 */
require_once dirname( __DIR__ ) . '/includes/parsers/class-shurloc-mesh-parser.php';

/*
 * Load analyzers.
 */
require_once dirname( __DIR__ ) . '/includes/analyzers/class-shurloc-catalog-analyzer.php';
require_once dirname( __DIR__ ) . '/includes/analyzers/class-shurloc-mesh-product-analyzer.php';

/*
 * Load services.
 */
require_once dirname( __DIR__ ) . '/includes/services/class-shurloc-product-catalog-service.php';
require_once dirname( __DIR__ ) . '/includes/services/class-shurloc-mesh-product-schema-service.php';
require_once dirname( __DIR__ ) . '/includes/services/class-shurloc-product-schema-service.php';

/*
 * Load generators.
 */
require_once dirname( __DIR__ ) . '/includes/generators/class-shurloc-product-schema-generator.php';

/*
 * Load reports.
 */
require_once dirname( __DIR__ ) . '/includes/reports/class-shurloc-catalog-report.php';

/*
 * Load integrations.
 */
require_once dirname( __DIR__ ) . '/includes/integrations/class-shurloc-product-schema-integration.php';

// Load renderers.
require_once dirname( __DIR__ ) . '/includes/renderers/class-shurloc-product-schema-renderer.php';


/*
 * Load test utilities.
 */
require_once dirname( __DIR__ ) . '/tests/parsers/MeshParserDataProvider.php';
require_once dirname( __DIR__ ) . '/tests/integration/MeshCatalogDataProvider.php';

/**
 * Stub functions for WordPress.
 */

if ( ! function_exists( 'wp_json_encode' ) ) {
	/**
	 * WordPress JSON encode test stub.
	 *
	 * @param mixed $value   Value to encode.
	 * @param int   $flags   JSON encode flags.
	 * @param int   $depth   Maximum depth.
	 * @return string|false
	 */
	function wp_json_encode(
		$value,
		int $flags = 0,
		int $depth = 512
	) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode
		return json_encode(
			$value,
			$flags,
			$depth
		);
	}
}
