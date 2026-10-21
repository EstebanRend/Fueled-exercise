<?php
/**
 * WP Constants used by PHPStan
 *
 * These should be updated to match constants that are set in any custom plugins or themes that will be anylised.
 *
 * @package TenUpPhpStan
 */

// Change these when you update the constants in the plugin.
define( 'MERIDIAN_PLUGIN_VERSION', '0.1.0' );
define( 'MERIDIAN_PLUGIN_URL', '' );
define( 'MERIDIAN_PLUGIN_PATH', '' );
define( 'MERIDIAN_PLUGIN_INC', MERIDIAN_PLUGIN_PATH . 'includes/' );

// Change these when you update the constants in the theme.

define( 'MERIDIAN_THEME_VERSION', '1.0.0' );
define( 'MERIDIAN_THEME_TEMPLATE_URL', '' );
define( 'MERIDIAN_THEME_PATH', '/' );
define( 'MERIDIAN_THEME_DIST_PATH', MERIDIAN_THEME_PATH . 'dist/' );
define( 'MERIDIAN_THEME_DIST_URL', MERIDIAN_THEME_TEMPLATE_URL . '/dist/' );
define( 'MERIDIAN_THEME_INC', MERIDIAN_THEME_PATH . 'includes/' );
define( 'MERIDIAN_THEME_BLOCK_DIST_DIR', MERIDIAN_THEME_DIST_PATH . '/blocks/' );
