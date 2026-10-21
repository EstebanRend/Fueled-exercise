<?php
/**
 * Staff Member post type.
 *
 * @package MeridianTheme
 */

namespace MeridianTheme\PostTypes;

use TenupFramework\PostTypes\AbstractPostType;

/**
 * Registers the `staff_member` post type and its `job_title` meta.
 *
 * A staff member's name is the post title, their bio is the post content, and
 * their photo is the featured image. Their department is a `staff_department`
 * term (see ADR-004). Their job title is a single meta value.
 *
 * @package MeridianTheme
 */
class StaffMember extends AbstractPostType {

	/**
	 * Meta key holding a staff member's job title.
	 *
	 * @var string
	 */
	public const JOB_TITLE_META_KEY = 'meridian_job_title';

	/**
	 * Can this module be registered?
	 *
	 * @return bool
	 */
	public function can_register() {
		return true;
	}

	/**
	 * Get the post type name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'staff_member';
	}

	/**
	 * Get the singular post type label.
	 *
	 * @return string
	 */
	public function get_singular_label() {
		return __( 'Staff Member', 'meridian-theme' );
	}

	/**
	 * Get the plural post type label.
	 *
	 * @return string
	 */
	public function get_plural_label() {
		return __( 'Staff', 'meridian-theme' );
	}

	/**
	 * Get the menu icon for the post type.
	 *
	 * @return string
	 */
	public function get_menu_icon() {
		return 'dashicons-groups';
	}

	/**
	 * Post type options.
	 *
	 * Staff members are surfaced two ways: individually at a clean, human-readable
	 * permalink, and collectively on the `/team/` directory archive. We set the
	 * rewrite slug explicitly so both live under `/team/` — `/team/{name}/` for a
	 * person and `/team/` for the directory — rather than under the raw
	 * `staff_member` post-type key. `has_archive` is stated explicitly (rather than
	 * left to the framework default) so the archive route is a deliberate, visible
	 * decision.
	 *
	 * @return array<string, mixed>
	 */
	public function get_options() {
		$options                = parent::get_options();
		$options['has_archive'] = true;
		$options['rewrite']     = [
			'slug'       => 'team',
			'with_front' => false,
		];

		return $options;
	}

	/**
	 * Supported editor features.
	 *
	 * Title (name), editor (bio), thumbnail (photo), and excerpt (short intro).
	 * `custom-fields` is required for the registered `job_title` meta to be
	 * exposed in the REST API — without it WordPress omits the `meta` field for a
	 * custom post type, so the block editor (and the Staff details panel) cannot
	 * read or write it.
	 *
	 * @return array<string>
	 */
	public function get_editor_supports() {
		return [
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'revisions',
			'custom-fields',
		];
	}

	/**
	 * Taxonomies associated with this post type.
	 *
	 * @return array<string>
	 */
	public function get_supported_taxonomies() {
		return [ 'staff_department' ];
	}

	/**
	 * Register the job title meta after the post type is registered.
	 *
	 * @return void
	 */
	public function after_register() {
		register_post_meta(
			$this->get_name(),
			self::JOB_TITLE_META_KEY,
			[
				'type'              => 'string',
				'description'       => __( 'The staff member’s job title.', 'meridian-theme' ),
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => static function (): bool {
					return current_user_can( 'edit_posts' );
				},
			]
		);
	}
}
