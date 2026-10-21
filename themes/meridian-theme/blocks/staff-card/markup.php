<?php
/**
 * Staff Card block markup.
 *
 * @package MeridianTheme
 *
 * @var array{postId?: int} $attributes Block attributes.
 * @var string              $content    Block content.
 * @var WP_Block            $block      Block instance.
 */

$meridian_post_id = (int) ( $attributes['postId'] ?? 0 );

if ( ! $meridian_post_id ) {
	return;
}

$meridian_card = \MeridianTheme\People\StaffCard::render( $meridian_post_id );

if ( '' === $meridian_card ) {
	return;
}
?>
<div <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core-generated attribute string. ?>>
	<?php echo $meridian_card; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- StaffCard::render() escapes every dynamic value. ?>
</div>
