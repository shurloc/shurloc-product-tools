<?php
/**
 * WordPress function test doubles.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

/*
 * Define the WordPress cache-duration constant when WordPress is not loaded.
 */
if ( ! defined( 'MINUTE_IN_SECONDS' ) ) {
	define( 'MINUTE_IN_SECONDS', 60 );
}


/**
 * Globals for testing.
 */

/**
 * Test product state.
 */
$GLOBALS['shurloc_test_is_product'] = true;

/**
 * Registered test filters.
 */
$GLOBALS['shurloc_test_filters'] = array();

/**
 * Registered test actions.
 */
$GLOBALS['shurloc_test_actions'] = array();

/**
 * Registered test action metadata.
 */
$GLOBALS['shurloc_test_action_metadata'] = array();

/**
 * Stored taxonomy terms.
 */
$GLOBALS['shurloc_test_terms'] = array();

/**
 * Stored product comments.
 */
$GLOBALS['shurloc_test_comments'] = array();

/**
 * Product IDs returned by get_posts().
 */
$GLOBALS['shurloc_test_product_ids'] = array();

/**
 * Registered WooCommerce test products.
 */
$GLOBALS['shurloc_test_products'] = array();

/**
 * Stored shortcode registrations.
 */
$GLOBALS['wp_shortcodes'] = array();

/**
 * Stored product.
 */
$GLOBALS['product'] = null;

/**
 * Enqueued styles.
 */
$GLOBALS['shurloc_test_enqueued_styles'] = array();

/**
 * Enqueued scripts.
 */
$GLOBALS['shurloc_test_enqueued_scripts'] = array();

/**
 * Recorded nonce verification checks.
 */
$GLOBALS['shurloc_test_nonce_checks'] = array();

/**
 * Registered styles.
 */
$GLOBALS['shurloc_test_registered_styles'] = array();

/**
 * Registered scripts.
 */
$GLOBALS['shurloc_test_registered_scripts'] = array();

/**
 * Test transients.
 */
$GLOBALS['shurloc_test_transients'] = array();

/**
 * Test options.
 */
$GLOBALS['shurloc_test_options'] = array();

/**
 * Product post types keyed by object ID.
 */
$GLOBALS['shurloc_test_post_types'] = array();

/**
 * Test autosave IDs.
 */
$GLOBALS['shurloc_test_autosaves'] = array();

/**
 * Test revision IDs.
 */
$GLOBALS['shurloc_test_revisions'] = array();

/**
 * Registered top-level admin menu pages.
 */
$GLOBALS['shurloc_test_menu_pages'] = array();

/**
 * Registered admin submenu pages.
 */
$GLOBALS['shurloc_test_submenu_pages'] = array();

/**
 * Removed admin submenu pages.
 */
$GLOBALS['shurloc_test_removed_submenus'] = array();


/**
 * Function doubles.
 */

if ( ! function_exists( 'wp_json_encode' ) ) {

	/**
	 * WordPress JSON encode test stub.
	 *
	 * @param mixed       $value Value to encode.
	 * @param int         $flags JSON encode flags.
	 * @param int<1, max> $depth Maximum depth.
	 * @return string|false
	 */
	// phpcs:ignore Squiz.Commenting.FunctionComment.IncorrectTypeHint, Squiz.Commenting.FunctionComment.Missing
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


if ( ! function_exists( 'is_product' ) ) {

	/**
	 * Determine whether current page is a product page.
	 *
	 * @return bool
	 */
	function is_product(): bool {

		return $GLOBALS['shurloc_test_is_product'];
	}
}


if ( ! function_exists( 'get_the_ID' ) ) {

	/**
	 * Get current post ID.
	 *
	 * @return int
	 */
	// phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid, Squiz.Commenting.FunctionComment.Missing
	function get_the_ID(): int {

		return 123;
	}
}


if ( ! function_exists( 'add_filter' ) ) {

	/**
	 * Register test filter.
	 *
	 * @param string   $hook Hook name.
	 * @param callable $callback Callback.
	 * @param int      $priority Priority.
	 * @param int      $accepted_args Accepted arguments.
	 * @return true
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function add_filter(
		string $hook,
		$callback,
		int $priority = 10,
		int $accepted_args = 1
	): bool {

		$GLOBALS['shurloc_test_filters'][ $hook ][] = $callback;

		return true;
	}
}


if ( ! function_exists( 'has_filter' ) ) {

	/**
	 * Check whether a filter is registered.
	 *
	 * @param string        $hook     Hook name.
	 * @param callable|null $callback Optional callback.
	 * @return int|bool Priority if found, true if callbacks exist and no callback
	 *                   was specified, otherwise false.
	 */
	function has_filter(
		string $hook,
		$callback = null
	) {

		if ( empty( $GLOBALS['shurloc_test_filters'][ $hook ] ) ) {
			return false;
		}

		if ( null === $callback ) {
			return true;
		}

		foreach (
			$GLOBALS['shurloc_test_filters'][ $hook ]
			as $registered
		) {

			if ( $registered === $callback ) {
				return 10;
			}
		}

		return false;
	}
}


if ( ! function_exists( 'apply_filters' ) ) {

	/**
	 * Apply test filters.
	 *
	 * @param string $hook Hook name.
	 * @param mixed  $value Value to filter.
	 * @return mixed
	 */
	function apply_filters(
		string $hook,
		$value
	) {

		if ( empty( $GLOBALS['shurloc_test_filters'][ $hook ] ) ) {
			return $value;
		}

		foreach ( $GLOBALS['shurloc_test_filters'][ $hook ] as $callback ) {
			$value = $callback( $value );
		}

		return $value;
	}
}


if ( ! function_exists( 'add_action' ) ) {

	/**
	 * Register test action.
	 *
	 * @param string   $hook Hook name.
	 * @param callable $callback Callback.
	 * @param int      $priority Priority.
	 * @param int      $accepted_args Accepted arguments.
	 * @return true
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function add_action(
		string $hook,
		$callback,
		int $priority = 10,
		int $accepted_args = 1
	): bool {

		if ( ! isset( $GLOBALS['shurloc_test_actions'] ) ) {

			$GLOBALS['shurloc_test_actions'] = array();
		}

		$GLOBALS['shurloc_test_actions'][ $hook ][] = $callback;

		$GLOBALS['shurloc_test_action_metadata'][ $hook ][] = array(
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);

		return true;
	}
}


if ( ! function_exists( 'has_action' ) ) {

	/**
	 * Check whether an action is registered.
	 *
	 * @param string   $hook Hook name.
	 * @param callable $callback Optional callback.
	 * @return int|bool Priority or bool.
	 */
	function has_action(
		string $hook,
		$callback = null
	) {

		if (
			empty(
				$GLOBALS['shurloc_test_actions'][ $hook ]
			)
		) {
			return false;
		}

		if ( null === $callback ) {
			return true;
		}

		foreach (
			$GLOBALS['shurloc_test_actions'][ $hook ]
			as $registered
		) {

			if ( $registered === $callback ) {

				return 10;
			}
		}

		return false;
	}
}


if ( ! function_exists( 'do_action' ) ) {

	/**
	 * Execute test actions.
	 *
	 * @param string $hook Hook name.
	 * @param mixed  ...$args Action arguments.
	 * @return void
	 */
	function do_action(
		string $hook,
		...$args
	): void {

		if ( empty( $GLOBALS['shurloc_test_actions'][ $hook ] ) ) {
			return;
		}

		foreach ( $GLOBALS['shurloc_test_actions'][ $hook ] as $callback ) {
			$callback( ...$args );
		}
	}
}


if ( ! function_exists( 'get_edit_post_link' ) ) {

	/**
	 * Get edit post link.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $context Context.
	 * @return string
	 */
    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function get_edit_post_link(
		int $post_id,
		string $context = ''
	): string {

		return 'https://example.com/wp-admin/post.php?post=' . $post_id;
	}
}


if ( ! function_exists( 'get_permalink' ) ) {

	/**
	 * Get permalink.
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	function get_permalink(
		int $post_id
	): string {

		return 'https://example.com/product/' . $post_id . '/';
	}
}


if ( ! function_exists( 'wp_set_object_terms' ) ) {

	/**
	 * Set object terms.
	 *
	 * @param int                      $object_id Object ID.
	 * @param string|array<string|int> $terms Terms.
	 * @param string                   $taxonomy Taxonomy.
	 * @return bool
	 */
	function wp_set_object_terms(
		int $object_id,
		$terms,
		string $taxonomy
	): bool {

		if ( ! isset( $GLOBALS['shurloc_test_terms'][ $object_id ] ) ) {
			$GLOBALS['shurloc_test_terms'][ $object_id ] = array();
		}

		$GLOBALS['shurloc_test_terms'][ $object_id ][ $taxonomy ] = (array) $terms;

		return true;
	}
}


if ( ! function_exists( 'get_the_terms' ) ) {

	/**
	 * Get object terms.
	 *
	 * @param int    $object_id Object ID.
	 * @param string $taxonomy Taxonomy.
	 * @return array<int,string>
	 */
	function get_the_terms(
		int $object_id,
		string $taxonomy
	): array {

		return $GLOBALS['shurloc_test_terms'][ $object_id ][ $taxonomy ] ?? array();
	}
}

if ( ! function_exists( 'wp_get_post_terms' ) ) {

	/**
	 * Get post terms.
	 *
	 * @param int                  $post_id Post ID.
	 * @param string               $taxonomy Taxonomy.
	 * @param array<string,mixed>  $args Arguments.
	 * @return array<int,string>
	 */
    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function wp_get_post_terms(
		int $post_id,
		string $taxonomy,
		array $args = array()
	): array {

		return $GLOBALS['shurloc_test_terms'][ $post_id ][ $taxonomy ] ?? array();
	}
}

if ( ! function_exists( 'wp_get_attachment_image_url' ) ) {

	/**
	 * Get attachment image URL.
	 *
	 * @param int    $attachment_id Attachment ID.
	 * @param string $size Image size.
	 * @return false
	 */
    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function wp_get_attachment_image_url(
		int $attachment_id,
		string $size = 'full'
	) {

		return false;
	}
}

if ( ! function_exists( 'is_wp_error' ) ) {

	/**
	 * Determine whether a value is a WP_Error object.
	 *
	 * @param mixed $thing Value to check.
	 * @return bool
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found, Squiz.Commenting.FunctionComment.Missing
	function is_wp_error(
		$thing
	): bool {

		return false;
	}
}

if ( ! function_exists( 'get_comments' ) ) {

	/**
	 * Get test comments.
	 *
	 * @param array<string,mixed> $args Comment query arguments.
	 * @return array<int,object>
	 */
	function get_comments(
		array $args = array()
	): array {

		$post_id = $args['post_id'] ?? 0;

		return $GLOBALS['shurloc_test_comments'][ $post_id ] ?? array();
	}
}

if ( ! function_exists( 'shurloc_register_test_product' ) ) {

	/**
	 * Register WooCommerce test product.
	 *
	 * @param WC_Product $product Product object.
	 * @return void
	 */
	function shurloc_register_test_product(
		WC_Product $product
	): void {

		$GLOBALS['shurloc_test_products'][ $product->get_id() ] = $product;
	}
}

if ( ! function_exists( 'plugin_dir_path' ) ) {

	/**
	 * Return plugin directory path stub.
	 *
	 * @param string $file Plugin file.
	 * @return string
	 */
	function plugin_dir_path(
		string $file
	): string {

		return defined( 'SHURLOC_PRODUCT_TOOLS_PATH' )
			? SHURLOC_PRODUCT_TOOLS_PATH
			: dirname( $file ) . DIRECTORY_SEPARATOR;
	}
}

if ( ! function_exists( 'plugin_dir_url' ) ) {

	/**
	 * Return plugin URL stub.
	 *
	 * @param string $file Plugin file.
	 * @return string
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found, Squiz.Commenting.FunctionComment.Missing
	function plugin_dir_url(
		string $file
	): string {

		return 'https://example.com/wp-content/plugins/shurloc-product-tools/';
	}
}

if ( ! function_exists( 'check_admin_referer' ) ) {

	/**
	 * Test nonce verification.
	 *
	 * @param string $action Nonce action.
	 * @return true
	 */
	function check_admin_referer( string $action ): bool {

		$GLOBALS['shurloc_test_nonce_checks'][] = $action;

		return true;
	}
}

if ( ! function_exists( 'sanitize_key' ) ) {

	/**
	 * Sanitize a key.
	 *
	 * @param string $key Key.
	 * @return string
	 */
	function sanitize_key(
		string $key
	): string {

		$str = preg_replace(
			'/[^a-z0-9_\-]/',
			'',
			$key
		);

		if ( is_null( $str ) ) {
			return '';
		}

		return strtolower( $str );
	}
}

if ( ! function_exists( 'wp_unslash' ) ) {

	/**
	 * Remove slashes.
	 *
	 * @param mixed $value Value.
	 * @return mixed
	 */
	function wp_unslash( $value ) {

		return stripslashes_deep( $value );
	}
}

if ( ! function_exists( 'stripslashes_deep' ) ) {

	/**
	 * Remove slashes recursively.
	 *
	 * @param mixed $value Value.
	 * @return mixed
	 */
	function stripslashes_deep( $value ) {

		if ( is_array( $value ) ) {

			return array_map(
				'stripslashes_deep',
				$value
			);
		}

		return stripslashes( $value );
	}
}

if ( ! function_exists( 'current_user_can' ) ) {

	/**
	 * Capability check stub.
	 *
	 * @param string $capability Capability name.
	 * @return bool
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found, Squiz.Commenting.FunctionComment.Missing
	function current_user_can( string $capability ): bool {

		return true;
	}
}

if ( ! function_exists( 'esc_html' ) ) {
	/**
	 * Escape HTML output.
	 *
	 * @param string $text Text to escape.
	 * @return string Escaped text.
	 */
	function esc_html(
		string $text
	): string {

		return htmlspecialchars(
			$text,
			ENT_QUOTES | ENT_SUBSTITUTE,
			'UTF-8'
		);
	}
}

if ( ! function_exists( 'add_shortcode' ) ) {
	/**
	 * Register a shortcode callback.
	 *
	 * @param string   $tag      Shortcode tag.
	 * @param callable $callback Shortcode callback.
	 * @return bool True when the shortcode is registered.
	 */
	function add_shortcode(
		string $tag,
		callable $callback
	): bool {

		if ( ! isset( $GLOBALS['wp_shortcodes'] ) ) {
			$GLOBALS['wp_shortcodes'] = array();
		}

		$GLOBALS['wp_shortcodes'][ $tag ] = $callback;

		return true;
	}
}

if ( ! function_exists( 'wc_get_product' ) ) {

	/**
	 * Retrieve a registered WooCommerce product test double.
	 *
	 * Returns a previously registered product test double. Returns false when
	 * the requested product has not been registered, matching WooCommerce's
	 * behavior when a product cannot be found.
	 *
	 * @param int $product_id Product ID.
	 * @return WC_Product|false Registered product test double or false.
	 */
	function wc_get_product(
		int $product_id
	): WC_Product|false {

		if ( isset( $GLOBALS['shurloc_test_products'][ $product_id ] ) ) {
			return $GLOBALS['shurloc_test_products'][ $product_id ];
		}

		return false;
	}
}

if ( ! function_exists( 'wp_strip_all_tags' ) ) {

	/**
	 * Stub WordPress wp_strip_all_tags().
	 *
	 * @param string $text Text to sanitize.
	 * @return string
	 */
	function wp_strip_all_tags(
		string $text
	): string {

		return trim(
			// phpcs:ignore WordPress.WP.AlternativeFunctions.strip_tags_strip_tags
			strip_tags( $text )
		);
	}
}

if ( ! function_exists( 'is_singular' ) ) {

	/**
	 * Determine whether current request is singular.
	 *
	 * @return bool
	 */
	function is_singular(): bool {

		return true;
	}
}

if ( ! function_exists( 'has_shortcode' ) ) {

	/**
	 * Determine whether content contains a shortcode.
	 *
	 * @param string $content Content to search.
	 * @param string $tag     Shortcode tag.
	 * @return bool
	 */
	function has_shortcode(
		string $content,
		string $tag
	): bool {

		return str_contains(
			$content,
			'[' . $tag
		);
	}
}

if ( ! function_exists( 'wp_enqueue_style' ) ) {

	/**
	 * Register a test stylesheet enqueue.
	 *
	 * @param string            $handle Stylesheet handle.
	 * @param string|false      $src    Stylesheet source.
	 * @param array<int,string> $deps  Dependencies.
	 * @param string|false      $ver    Version.
	 * @param string            $media  Media type.
	 * @return void
	 */
	function wp_enqueue_style(
		string $handle,
		$src = false,
		array $deps = array(),
		$ver = false,
		string $media = 'all'
	): void {

		if ( ! isset( $GLOBALS['shurloc_test_styles'] ) ) {
			$GLOBALS['shurloc_test_styles'] = array();
		}

		$GLOBALS['shurloc_test_styles'][ $handle ] = array(
			'src'   => $src,
			'deps'  => $deps,
			'ver'   => $ver,
			'media' => $media,
		);
	}
}

if ( ! function_exists( 'wp_style_is' ) ) {

	/**
	 * Determine whether a test stylesheet has been enqueued.
	 *
	 * @param string $handle Stylesheet handle.
	 * @param string $status Status query.
	 * @return bool
	 */
	function wp_style_is(
		string $handle,
		string $status = 'enqueued'
	): bool {

		switch ( $status ) {

			case 'registered':
				return isset(
					$GLOBALS['shurloc_test_registered_styles'][ $handle ]
				);

			case 'enqueued':
				return isset(
					$GLOBALS['shurloc_test_enqueued_styles'][ $handle ]
				);

			default:
				return false;
		}
	}
}

if ( ! function_exists( 'wp_register_style' ) ) {

	/**
	 * Register a stylesheet.
	 *
	 * @param string            $handle Stylesheet handle.
	 * @param string|false      $src    Stylesheet source.
	 * @param array<int,string> $deps   Dependencies.
	 * @param string|false      $ver    Version.
	 * @param string            $media  Media type.
	 * @return void
	 */
	function wp_register_style(
		string $handle,
		$src = false,
		array $deps = array(),
		$ver = false,
		string $media = 'all'
	): void {

		$GLOBALS['shurloc_test_registered_styles'][ $handle ] = array(
			'src'   => $src,
			'deps'  => $deps,
			'ver'   => $ver,
			'media' => $media,
		);
	}
}

if ( ! function_exists( '__' ) ) {

	/**
	 * Translate text.
	 *
	 * Test stub that returns the original string.
	 *
	 * @param string $text   Text to translate.
	 * @param string $domain Text domain.
	 * @return string
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function __(
		string $text,
		string $domain = 'default'
	): string {

		return $text;
	}
}

if ( ! function_exists( '_e' ) ) {

	/**
	 * Echo translated text.
	 *
	 * @param string $text   Text to translate.
	 * @param string $domain Text domain.
	 * @return void
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function _e(
		string $text,
		string $domain = 'default'
	): void {

		echo esc_html( $text );
	}
}

if ( ! function_exists( 'esc_html__' ) ) {

	/**
	 * Translate and escape text.
	 *
	 * @param string $text   Text to translate.
	 * @param string $domain Text domain.
	 * @return string
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function esc_html__(
		string $text,
		string $domain = 'default'
	): string {

		return esc_html( $text );
	}
}

if ( ! function_exists( 'esc_html_e' ) ) {

	/**
	 * Translate, escape, and echo text.
	 *
	 * @param string $text   Text to translate.
	 * @param string $domain Text domain.
	 * @return void
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, Squiz.Commenting.FunctionComment.Missing
	function esc_html_e(
		string $text,
		string $domain = 'default'
	): void {

		echo esc_html( $text );
	}
}

if ( ! function_exists( 'esc_attr' ) ) {

	/**
	 * Escape an HTML attribute for tests.
	 *
	 * @param mixed $text Attribute value.
	 * @return string
	 */
	function esc_attr( $text ): string {

		return htmlspecialchars(
			(string) $text,
			ENT_QUOTES | ENT_SUBSTITUTE,
			'UTF-8'
		);
	}
}

if ( ! function_exists( 'wp_register_style' ) ) {

	/**
	 * Register a stylesheet for tests.
	 *
	 * @param string           $handle Handle.
	 * @param string           $src    Source URL.
	 * @param string[]         $deps   Dependencies.
	 * @param string|bool|null $ver    Version.
	 * @return void
	 */
	function wp_register_style(
		string $handle,
		string $src,
		array $deps = array(),
		$ver = false
	): void {

		$GLOBALS['shurloc_test_registered_styles'][ $handle ] = array(
			'src'  => $src,
			'deps' => $deps,
			'ver'  => $ver,
		);
	}
}

if ( ! function_exists( 'wp_register_script' ) ) {

	/**
	 * Register a script for tests.
	 *
	 * @param string           $handle    Handle.
	 * @param string           $src       Source URL.
	 * @param string[]         $deps      Dependencies.
	 * @param string|bool|null $ver       Version.
	 * @param bool             $in_footer Whether to load in the footer.
	 * @return void
	 */
	function wp_register_script(
		string $handle,
		string $src,
		array $deps = array(),
		$ver = false,
		bool $in_footer = false
	): void {

		$GLOBALS['shurloc_test_registered_scripts'][ $handle ] = array(
			'src'       => $src,
			'deps'      => $deps,
			'ver'       => $ver,
			'in_footer' => $in_footer,
		);
	}
}

if ( ! function_exists( 'wp_script_is' ) ) {

	/**
	 * Check whether a script is registered.
	 *
	 * @param string $handle Script handle.
	 * @param string $status Status to check.
	 * @return bool
	 */
	function wp_script_is(
		string $handle,
		string $status
	): bool {

		if ( 'registered' !== $status ) {
			return false;
		}

		return isset(
			$GLOBALS['shurloc_test_registered_scripts'][ $handle ]
		);
	}
}

if ( ! function_exists( 'wp_enqueue_script' ) ) {

	/**
	 * Register a test script enqueue.
	 *
	 * @param string            $handle    Script handle.
	 * @param string|false      $src       Script source.
	 * @param array<int,string> $deps      Dependencies.
	 * @param string|false      $ver       Version.
	 * @param bool              $in_footer Whether to enqueue in the footer.
	 * @return void
	 */
	function wp_enqueue_script(
		string $handle,
		$src = false,
		array $deps = array(),
		$ver = false,
		bool $in_footer = false
	): void {

		if ( ! isset( $GLOBALS['shurloc_test_scripts'] ) ) {
			$GLOBALS['shurloc_test_scripts'] = array();
		}

		$GLOBALS['shurloc_test_scripts'][ $handle ] = array(
			'src'       => $src,
			'deps'      => $deps,
			'ver'       => $ver,
			'in_footer' => $in_footer,
		);
	}
}

if ( ! function_exists( 'get_posts' ) ) {

	/**
	 * Test replacement for get_posts().
	 *
	 * @param array<string, mixed> $args Query arguments.
	 * @return int[]
	 */
	function get_posts(
		array $args = array()
	): array {

		$product_ids = $GLOBALS['shurloc_test_product_ids'];

		if (
			isset( $args['post__not_in'] ) &&
			is_array( $args['post__not_in'] )
		) {
			$product_ids = array_values(
				array_diff(
					$product_ids,
					array_map(
						'intval',
						$args['post__not_in']
					)
				)
			);
		}

		if (
			isset( $args['posts_per_page'] ) &&
			is_int( $args['posts_per_page'] ) &&
			0 < $args['posts_per_page']
		) {
			$product_ids = array_slice(
				$product_ids,
				0,
				$args['posts_per_page']
			);
		}

		return array_map(
			'intval',
			$product_ids
		);
	}
}

if ( ! function_exists( 'get_transient' ) ) {

	/**
	 * Retrieve a test transient.
	 *
	 * @param string $key Transient key.
	 *
	 * @return mixed
	 */
	function get_transient(
		string $key
	) {

		return $GLOBALS['shurloc_test_transients'][ $key ]
			?? false;
	}
}

if ( ! function_exists( 'set_transient' ) ) {

	/**
	 * Store a test transient.
	 *
	 * @param string $key        Transient key.
	 * @param mixed  $value      Transient value.
	 * @param int    $expiration Expiration in seconds.
	 *
	 * @return bool
	 */
	function set_transient(
		string $key,
		$value,
		int $expiration = 0
	): bool {

		unset( $expiration );

		$GLOBALS['shurloc_test_transients'][ $key ] = $value;

		return true;
	}
}

if ( ! function_exists( 'get_option' ) ) {

	/**
	 * Retrieve a test option.
	 *
	 * @param string $option  Option name.
	 * @param mixed  $default_value Default value.
	 *
	 * @return mixed
	 */
	function get_option(
		string $option,
		$default_value = false
	) {

		return $GLOBALS['shurloc_test_options'][ $option ]
			?? $default_value;
	}
}

if ( ! function_exists( 'update_option' ) ) {

	/**
	 * Update a test option.
	 *
	 * @param string $option   Option name.
	 * @param mixed  $value    Option value.
	 * @param bool   $autoload Whether to autoload the option.
	 *
	 * @return bool
	 */
	function update_option(
		string $option,
		$value,
		bool $autoload = true
	): bool {

		unset( $autoload );

		$GLOBALS['shurloc_test_options'][ $option ] = $value;

		return true;
	}
}

if ( ! function_exists( 'wp_is_post_autosave' ) ) {

	/**
	 * Determine whether a post is an autosave.
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return int|false
	 */
	function wp_is_post_autosave(
		int $post_id
	) {

		return in_array(
			$post_id,
			$GLOBALS['shurloc_test_autosaves'],
			true
		)
			? $post_id
			: false;
	}
}

if ( ! function_exists( 'wp_is_post_revision' ) ) {

	/**
	 * Determine whether a post is a revision.
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return int|false
	 */
	function wp_is_post_revision(
		int $post_id
	) {

		return in_array(
			$post_id,
			$GLOBALS['shurloc_test_revisions'],
			true
		)
			? $post_id
			: false;
	}
}

if ( ! function_exists( 'get_post_type' ) ) {

	/**
	 * Retrieve a test post type.
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return string|false
	 */
	function get_post_type(
		int $post_id
	) {

		return $GLOBALS['shurloc_test_post_types'][ $post_id ]
			?? false;
	}
}

if ( ! function_exists( 'add_menu_page' ) ) {

	/**
	 * Test replacement for add_menu_page().
	 *
	 * @param string         $page_title Page title.
	 * @param string         $menu_title Menu title.
	 * @param string         $capability Required capability.
	 * @param string         $menu_slug  Menu slug.
	 * @param callable|null  $callback   Page callback.
	 * @param string         $icon_url   Menu icon.
	 * @param int|float|null $position  Menu position.
	 *
	 * @return string
	 */
	function add_menu_page(
		string $page_title,
		string $menu_title,
		string $capability,
		string $menu_slug,
		?callable $callback = null,
		string $icon_url = '',
		$position = null
	): string {

		$GLOBALS['shurloc_test_menu_pages'][] = array(
			'page_title' => $page_title,
			'menu_title' => $menu_title,
			'capability' => $capability,
			'menu_slug'  => $menu_slug,
			'callback'   => $callback,
			'icon_url'   => $icon_url,
			'position'   => $position,
		);

		return 'toplevel_page_' . $menu_slug;
	}
}

if ( ! function_exists( 'add_submenu_page' ) ) {

	/**
	 * Test replacement for add_submenu_page().
	 *
	 * @param string         $parent_slug Parent menu slug.
	 * @param string         $page_title  Page title.
	 * @param string         $menu_title  Menu title.
	 * @param string         $capability  Required capability.
	 * @param string         $menu_slug   Menu slug.
	 * @param callable|null  $callback    Page callback.
	 * @param int|float|null $position   Submenu position.
	 *
	 * @return string
	 */
	function add_submenu_page(
		string $parent_slug,
		string $page_title,
		string $menu_title,
		string $capability,
		string $menu_slug,
		?callable $callback = null,
		$position = null
	): string {

		$GLOBALS['shurloc_test_submenu_pages'][] = array(
			'parent_slug' => $parent_slug,
			'page_title'  => $page_title,
			'menu_title'  => $menu_title,
			'capability'  => $capability,
			'menu_slug'   => $menu_slug,
			'callback'    => $callback,
			'position'    => $position,
		);

		return $parent_slug . '_page_' . $menu_slug;
	}
}

if ( ! function_exists( 'remove_submenu_page' ) ) {

	/**
	 * Test replacement for remove_submenu_page().
	 *
	 * @param string $menu_slug    Parent menu slug.
	 * @param string $submenu_slug Submenu slug.
	 *
	 * @return false
	 */
	function remove_submenu_page(
		string $menu_slug,
		string $submenu_slug
	) {

		$GLOBALS['shurloc_test_removed_submenus'][] = array(
			'parent_slug' => $menu_slug,
			'menu_slug'   => $submenu_slug,
		);

		return false;
	}
}

if ( ! function_exists( 'esc_url' ) ) {

	/**
	 * Escape a URL.
	 *
	 * Test replacement for esc_url().
	 *
	 * @param string $url URL.
	 * @return string
	 */
	function esc_url(
		string $url
	): string {

		return $url;
	}
}

if ( ! function_exists( 'add_query_arg' ) ) {

	/**
	 * Add query arguments to a URL.
	 *
	 * Test replacement for add_query_arg().
	 *
	 * @param array<string, scalar> $args Query arguments.
	 * @param string                $url  Base URL.
	 * @return string
	 */
	function add_query_arg(
		array $args,
		string $url
	): string {

		if ( empty( $args ) ) {
			return $url;
		}

		$separator = str_contains( $url, '?' )
			? '&'
			: '?';

		return $url . $separator . http_build_query( $args );
	}
}

if ( ! function_exists( 'admin_url' ) ) {

	/**
	 * Get an admin URL.
	 *
	 * Test replacement for admin_url().
	 *
	 * @param string $path Admin path.
	 * @return string
	 */
	function admin_url(
		string $path = ''
	): string {

		return 'https://example.com/wp-admin/' . ltrim( $path, '/' );
	}
}
