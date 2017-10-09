<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}
/**
 * Plugin Name: WP Save Post
 * Plugin URI: http://bbioon.com/
 * Description: Save posts in a private menu to read them later.
 * Version: 1.0
 * Author: BbioonThemes
 * Author URI: http://bbioon.com
 * License: GPL2+
 * Text Domain: sv
 * Domain Path: /framework/languages
 */

define( 'SV_CSS_URI', plugins_url( 'assets/css/', __FILE__ ) );
define( 'SV_JS_URI', plugins_url( 'assets/js/', __FILE__ ) );
define( 'SV_CORE_DIR', plugin_dir_path( __FILE__ ) . 'core' . DIRECTORY_SEPARATOR );

/**
 * Include plugin files
 */
require SV_CORE_DIR . 'assets.php';
require SV_CORE_DIR . 'init.php';