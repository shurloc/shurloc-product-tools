<?php
/**
 * WordPress post test double.
 *
 * @package ShurlocProductTools
 */

declare( strict_types=1 );

/**
 * WordPress post test double.
 */
if ( ! class_exists( 'WP_Post' ) ) {

	/**
	 * WordPress post test double.
	 */
	class WP_Post {

		/**
		 * Post ID.
		 *
		 * @var int
		 */
		public int $ID = 0;

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

		/**
		 * Constructor.
		 *
		 * @param object $post Post data.
		 */
		public function __construct(
			object $post
		) {

			if ( isset( $post->ID ) ) {
				$this->ID = (int) $post->ID;
			}

			if ( isset( $post->post_content ) ) {
				$this->post_content =
					(string) $post->post_content;
			}

			if ( isset( $post->post_type ) ) {
				$this->post_type =
					(string) $post->post_type;
			}
		}
	}
}
