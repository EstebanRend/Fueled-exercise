<?php
/**
 * Staff card presentation.
 *
 * @package MeridianTheme
 */

namespace MeridianTheme\People;

use MeridianTheme\PostTypes\StaffMember;
use WP_Post;
use WP_Term;

/**
 * Renders a single staff member as a self-contained card.
 *
 * This is the one place staff-member markup is assembled, so the standalone
 * `meridian/staff-card` block and the `meridian/staff-list` block present a
 * person identically. It is a plain presenter with two callers — not a data
 * layer over the post (see ADR-003).
 *
 * @package MeridianTheme
 */
class StaffCard {

	/**
	 * Render a staff member as an HTML card.
	 *
	 * Every dynamic value is escaped here, so callers may echo the returned
	 * string as trusted markup.
	 *
	 * @param int $post_id The staff member post ID.
	 * @return string Card HTML, or an empty string if the post is not a viewable staff member.
	 */
	public static function render( int $post_id ): string {
		$post = get_post( $post_id );

		if (
			! $post instanceof WP_Post
			|| 'staff_member' !== $post->post_type
			|| 'publish' !== $post->post_status
		) {
			return '';
		}

		$name       = get_the_title( $post );
		$job_title  = get_post_meta( $post_id, StaffMember::JOB_TITLE_META_KEY, true );
		$job_title  = is_string( $job_title ) ? $job_title : '';
		$department = self::get_department_name( $post_id );
		$bio        = get_the_excerpt( $post );

		ob_start();
		?>
		<article class="meridian-staff-card">
			<div class="meridian-staff-card__media">
				<?php echo self::get_media( $post ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core-generated, escaped markup. ?>
			</div>
			<div class="meridian-staff-card__body">
				<h3 class="meridian-staff-card__name"><?php echo esc_html( $name ); ?></h3>
				<?php if ( '' !== $job_title ) : ?>
					<p class="meridian-staff-card__title"><?php echo esc_html( $job_title ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $department ) : ?>
					<p class="meridian-staff-card__department"><?php echo esc_html( $department ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $bio ) : ?>
					<p class="meridian-staff-card__bio"><?php echo esc_html( $bio ); ?></p>
				<?php endif; ?>
			</div>
		</article>
		<?php

		return trim( (string) ob_get_clean() );
	}

	/**
	 * Get the featured image markup, or a neutral placeholder when absent.
	 *
	 * @param WP_Post $post The staff member post.
	 * @return string
	 */
	private static function get_media( WP_Post $post ): string {
		if ( has_post_thumbnail( $post ) ) {
			return get_the_post_thumbnail(
				$post,
				'medium',
				[
					'class'   => 'meridian-staff-card__photo',
					'loading' => 'lazy',
					'alt'     => '',
				]
			);
		}

		return '<span class="meridian-staff-card__photo meridian-staff-card__photo--placeholder" aria-hidden="true"></span>';
	}

	/**
	 * Get the staff member's department name.
	 *
	 * A staff member belongs to a single department (BR-002); if more than one is
	 * set, the first is used for display.
	 *
	 * @param int $post_id The staff member post ID.
	 * @return string The department name, or an empty string when none is set.
	 */
	private static function get_department_name( int $post_id ): string {
		$terms = get_the_terms( $post_id, 'staff_department' );

		if ( ! is_array( $terms ) ) {
			return '';
		}

		$first = reset( $terms );

		return $first instanceof WP_Term ? $first->name : '';
	}
}
