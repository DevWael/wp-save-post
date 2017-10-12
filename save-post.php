<?php
/**
 * Plugin Name: WP Save Post
 * Plugin URI: http://bbioon.com/
 * Description: Save posts in a private menu to read them later.
 * Version: 1.0
 * Author: BbioonThemes
 * Author URI: http://bbioon.com
 * License: GPL2+
 * Text Domain: sv
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

// Main Plugin Constants
define( 'SV_CSS_URI', plugins_url( 'assets/css/', __FILE__ ) );
define( 'SV_JS_URI', plugins_url( 'assets/js/', __FILE__ ) );
define( 'SV_CORE_DIR', plugin_dir_path( __FILE__ ) . 'core' . DIRECTORY_SEPARATOR );
define( 'SV_ADMIN_DIR', plugin_dir_path( __FILE__ ) . 'admin' . DIRECTORY_SEPARATOR );


/**
 * Include plugin files
 */
if ( is_admin() ) {
	require SV_ADMIN_DIR . 'init.php';
}
require SV_CORE_DIR . 'assets.php';
require SV_CORE_DIR . 'init.php';