<?php
/**
 * Testimonial post type.
 *
 * @package MeridianTheme
 */

namespace MeridianTheme\PostTypes;

use TenupFramework\PostTypes\AbstractPostType;

/**
 * Registers the `testimonial` post type and its attribution meta.
 *
 * The quotation is the post content, the attributed person's name is the post
 * title, and their role and company are single meta values (both optional per
 * BR-007).
 *
 * @package MeridianTheme
 */
class Testimonial extends AbstractPostType {

	/**
	 * Meta key holding the attributed person's role.
	 *
	 * @var string
	 */
	public const ROLE_META_KEY = 'meridian_testimonial_role';

	/**
	 * Meta key holding the attributed person's company.
	 *
	 * @var string
	 */
	public const COMPANY_META_KEY = 'meridian_testimonial_company';

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
		return 'testimonial';
	}

	/**
	 * Get the singular post type label.
	 *
	 * @return string
	 */
	public function get_singular_label() {
		return __( 'Testimonial', 'meridian-theme' );
	}

	/**
	 * Get the plural post type label.
	 *
	 * @return string
	 */
	public function get_plural_label() {
		return __( 'Testimonials', 'meridian-theme' );
	}

	/**
	 * Get the menu icon for the post type.
	 *
	 * @return string
	 */
	public function get_menu_icon() {
		return 'dashicons-format-quote';
	}

	/**
	 * Supported editor features.
	 *
	 * Title (attributed name) and editor (the quotation). `custom-fields` is
	 * required for the registered role/company meta to be exposed in the REST
	 * API — without it WordPress omits the `meta` field for a custom post type,
	 * so the block editor (and the Attribution panel) cannot read or write it.
	 *
	 * @return array<string>
	 */
	public function get_editor_supports() {
		return [
			'title',
			'editor',
			'revisions',
			'custom-fields',
		];
	}

	/**
	 * Testimonials are curated content chosen by reference, so they have no
	 * public archive and are not publicly queryable on their own.
	 *
	 * @return array{
	 *      labels?: array<string|int, string>,
	 *      description?: string,
	 *      public?: bool,
	 *      hierarchical?: bool,
	 *      exclude_from_search?: bool,
	 *      publicly_queryable?: bool,
	 *      show_ui?: bool,
	 *      show_in_menu?: bool,
	 *      show_in_nav_menus?: bool,
	 *      show_in_admin_bar?: bool,
	 *      menu_position?: int,
	 *      menu_icon?: string,
	 *      capability_type?: string|array<int, string>,
	 *      capabilities?: array<string, string>,
	 *      map_meta_cap?: bool,
	 *      supports?: array<string>|false,
	 *      register_meta_box_cb?: callable,
	 *      taxonomies?: array<string>,
	 *      has_archive?: bool|string,
	 *      rewrite?: bool|array{
	 *          slug?: string,
	 *          with_front?: bool,
	 *          feeds?: bool,
	 *          pages?: bool,
	 *          ep_mask?: int,
	 *      },
	 *      query_var?: bool|string,
	 *      can_export?: bool,
	 *      delete_with_user?: bool,
	 *      show_in_rest?: bool,
	 *      rest_base?: string,
	 *      rest_namespace?: string,
	 *      rest_controller_class?: string,
	 *      _builtin?: bool,
	 *      template?: array<array<string, mixed>>,
	 *      template_lock?: string|false,
	 *  }
	 */
	public function get_options() {
		$options                       = parent::get_options();
		$options['has_archive']        = false;
		$options['publicly_queryable'] = false;

		return $options;
	}

	/**
	 * Register the attribution meta after the post type is registered.
	 *
	 * @return void
	 */
	public function after_register() {
		$args = [
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => static function (): bool {
				return current_user_can( 'edit_posts' );
			},
		];

		register_post_meta(
			$this->get_name(),
			self::ROLE_META_KEY,
			array_merge(
				$args,
				[ 'description' => __( 'The role or title of the person quoted.', 'meridian-theme' ) ]
			)
		);

		register_post_meta(
			$this->get_name(),
			self::COMPANY_META_KEY,
			array_merge(
				$args,
				[ 'description' => __( 'The company of the person quoted.', 'meridian-theme' ) ]
			)
		);
	}
}
