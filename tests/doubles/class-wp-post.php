<?php
/**
 * WordPress post test double.
 *
 * @package ShurLocProductTools
 */

declare(strict_types=1);

/**
 * WordPress post test double.
 */
if ( ! class_exists( 'WP_Post' ) ) {

	/**
	 * WordPress post test double.
	 */
	class WP_Post {

		/**
		 * Post content.
		 *
		 * @var string
		 */
		public string $post_content = '';

		/**
		 * Post type.
		 *
		 * @var string
		 */
		public string $post_type = 'post';
	}
}
