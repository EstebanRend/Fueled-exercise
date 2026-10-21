<?php
/**
 * Staff List block markup.
 *
 * Renders current staff as a grid of cards. Each card is produced by the same
 * presenter the Staff Card block uses, so a person looks identical in both
 * places. With a positive `maxPosts` the block is a teaser — it shows that many
 * people and links to the full `/team/` directory when more exist.
 *
 * @package MeridianTheme
 *
 * @var array<string, mixed> $attributes Block attributes.
 * @var string               $content    Block content.
 * @var WP_Block             $block      Block instance.
 */

$meridian_raw     = $attributes['maxPosts'] ?? 0;
$meridian_max     = is_numeric( $meridian_raw ) ? max( 0, (int) $meridian_raw ) : 0;
$meridian_limited = $meridian_max > 0;

$meridian_query = new WP_Query(
	[
		'post_type'           => 'staff_member',
		'post_status'         => 'publish',
		'posts_per_page'      => $meridian_limited ? $meridian_max : 100,
		'orderby'             => 'title',
		'order'               => 'ASC',
		// Only need the total when limiting, to decide whether to show the "view all" link.
		'no_found_rows'       => ! $meridian_limited,
		'ignore_sticky_posts' => true,
	]
);

if ( ! $meridian_query->have_posts() ) {
	return;
}

$meridian_cards = '';

foreach ( $meridian_query->posts as $meridian_member ) {
	if ( $meridian_member instanceof WP_Post ) {
		$meridian_cards .= \MeridianTheme\People\StaffCard::render( $meridian_member->ID );
	}
}

if ( '' === $meridian_cards ) {
	return;
}

// In teaser mode, link to the full directory when more staff exist than are shown.
$meridian_more = '';
if ( $meridian_limited && $meridian_query->found_posts > $meridian_query->post_count ) {
	$meridian_archive_url = get_post_type_archive_link( 'staff_member' );

	if ( $meridian_archive_url ) {
		$meridian_more = sprintf(
			'<p class="meridian-staff-list__more"><a class="meridian-staff-list__more-link" href="%1$s">%2$s</a></p>',
			esc_url( $meridian_archive_url ),
			esc_html__( 'View the full team →', 'meridian-theme' )
		);
	}
}
?>
<div <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core-generated attribute string. ?>>
	<div class="meridian-staff-list">
		<?php echo $meridian_cards; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- StaffCard::render() escapes every dynamic value. ?>
	</div>
	<?php echo $meridian_more; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Built from esc_url() and esc_html__() above. ?>
</div>
