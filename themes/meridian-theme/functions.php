<?php
/**
 * Theme constants and setup functions
 *
 * @package MeridianTheme
 */

// Useful global constants.
define( 'MERIDIAN_THEME_VERSION', '1.0.0' );
define( 'MERIDIAN_THEME_TEMPLATE_URL', get_template_directory_uri() );
define( 'MERIDIAN_THEME_PATH', get_template_directory() . '/' );
define( 'MERIDIAN_THEME_DIST_PATH', MERIDIAN_THEME_PATH . 'dist/' );
define( 'MERIDIAN_THEME_DIST_URL', MERIDIAN_THEME_TEMPLATE_URL . '/dist/' );
define( 'MERIDIAN_THEME_INC', MERIDIAN_THEME_PATH . 'src/' );
define( 'MERIDIAN_THEME_BLOCK_DIST_DIR', MERIDIAN_THEME_DIST_PATH . 'blocks/' );

// Require the Composer autoloader. If it's missing — e.g. a fresh checkout where
// dependencies haven't been installed yet — degrade gracefully instead of
// throwing a fatal. A fatal here takes down the whole site and WP-CLI, which
// also aborts `wp-env start` before its afterStart provisioning can install the
// dependencies (leaving the site unrecoverable via a normal start). Bailing out
// with an admin notice instead lets WordPress boot, so the tooling can heal it.
if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	add_action(
		'admin_notices',
		static function () {
			printf(
				'<div class="notice notice-error"><p>%s</p></div>',
				esc_html__(
					'Meridian theme dependencies are not installed. Run `npx @wordpress/env start` from the project root to install them.',
					'meridian-theme'
				)
			);
		}
	);

	return;
}

$is_local_env = in_array( wp_get_environment_type(), [ 'local', 'development' ], true );
$is_local_url = strpos( home_url(), '.test' ) || strpos( home_url(), '.local' );
$is_local     = $is_local_env || $is_local_url;

if ( $is_local && file_exists( __DIR__ . '/dist/fast-refresh.php' ) ) {
	require_once __DIR__ . '/dist/fast-refresh.php';

	if ( function_exists( 'TenUpToolkit\set_dist_url_path' ) ) {
		TenUpToolkit\set_dist_url_path( basename( __DIR__ ), MERIDIAN_THEME_DIST_URL, MERIDIAN_THEME_DIST_PATH );
	}
}

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/template-tags.php';

$theme_core = new \MeridianTheme\ThemeCore();
$theme_core->setup();
