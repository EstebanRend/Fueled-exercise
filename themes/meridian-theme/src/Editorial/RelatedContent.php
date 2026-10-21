<?php
/**
 * Related Content feature.
 *
 * @package MeridianTheme
 */

namespace MeridianTheme\Editorial;

use TenupFramework\Module;
use TenupFramework\ModuleInterface;
use WP_Post;
use WP_Query;

/**
 * Appends a set of related articles to the end of a single article.
 *
 * Relatedness is derived from the article's categories (BR-008). The computation
 * runs on high-traffic article pages, so its result is cached.
 *
 * @package MeridianTheme
 */
class RelatedContent implements ModuleInterface {

	use Module;

	/**
	 * How many related articles to show.
	 *
	 * @var int
	 */
	private const NUMBER_OF_ARTICLES = 3;

	/**
	 * How long to cache a computed related set.
	 *
	 * @var int
	 */
	private const CACHE_TTL = HOUR_IN_SECONDS;

	/**
	 * Can this module be registered?
	 *
	 * @return bool
	 */
	public function can_register() {
		return true;
	}

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function register() {
		add_filter( 'the_content', [ $this, 'append_related_articles' ] );
	}

	/**
	 * Append related articles to a single article's content.
	 *
	 * @param string $content The post content.
	 * @return string
	 */
	public function append_related_articles( $content ) {
		if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		$post_id = get_the_ID();

		if ( ! $post_id ) {
			return $content;
		}

		$related_ids = $this->get_related_article_ids( (int) $post_id );

		if ( empty( $related_ids ) ) {
			return $content;
		}

		return $content . $this->render( $related_ids );
	}

	/**
	 * Get the IDs of articles related to the given article.
	 *
	 * Related articles share at least one category with the current article,
	 * exclude the article itself, and are published (BR-009, BR-010).
	 *
	 * @param int $post_id The current article ID.
	 * @return array<int, int> Related article IDs.
	 */
	private function get_related_article_ids( int $post_id ): array {
		$cache_key = 'meridian_related_articles';

		$cached = get_transient( $cache_key );

		if ( is_array( $cached ) ) {
			return $cached;
		}

		$category_ids = wp_get_post_categories( $post_id );

		if ( empty( $category_ids ) ) {
			return [];
		}

		$query = new WP_Query(
			[
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'post__not_in'        => [ $post_id ],
				'category__in'        => $category_ids,
				'posts_per_page'      => self::NUMBER_OF_ARTICLES,
				'orderby'             => 'date',
				'order'               => 'DESC',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			]
		);

		$ids = [];

		foreach ( $query->posts as $related_post ) {
			if ( $related_post instanceof WP_Post ) {
				$ids[] = $related_post->ID;
			}
		}

		set_transient( $cache_key, $ids, self::CACHE_TTL );

		return $ids;
	}

	/**
	 * Render the related-articles section.
	 *
	 * @param array<int, int> $related_ids Related article IDs.
	 * @return string
	 */
	private function render( array $related_ids ): string {
		$items = '';

		foreach ( $related_ids as $related_id ) {
			$permalink = get_permalink( $related_id );

			if ( false === $permalink ) {
				continue;
			}

			$items .= sprintf(
				'<li class="meridian-related-content__item"><a href="%1$s">%2$s</a></li>',
				esc_url( $permalink ),
				esc_html( get_the_title( $related_id ) )
			);
		}

		if ( '' === $items ) {
			return '';
		}

		return sprintf(
			'<aside class="meridian-related-content"><h2 class="meridian-related-content__heading">%1$s</h2><ul class="meridian-related-content__list">%2$s</ul></aside>',
			esc_html__( 'Related articles', 'meridian-theme' ),
			$items
		);
	}
}
