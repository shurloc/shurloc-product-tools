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
require_once dirname( __DIR__ ) . '/includes/integrations/class-shurloc-product-schema-output.php';

/*
 * Load test utilities.
 */
require_once dirname( __DIR__ ) . '/tests/parsers/MeshParserDataProvider.php';
require_once dirname( __DIR__ ) . '/tests/integration/MeshCatalogDataProvider.php';
