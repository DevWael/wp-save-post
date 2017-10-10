<?php
/**
 * Admin Dashboard goes here
 */

add_action( 'admin_menu', 'sv_admin_menu_pages' );
function sv_admin_menu_pages() {
	add_menu_page( 'Main setting', 'WP Save Posts', 'manage_options', 'sv_main_setting_page', 'sv_main_setting_page', 'dashicons-tickets', 40 );


	add_submenu_page( 'sv_main_setting_page', 'other settings', 'Other Settings', 'manage_options', 'sv_other_setting_page', 'sv_other_setting_page' );
}

function sv_main_setting_page() {
	require SV_ADMIN_DIR . 'main-setting-template.php';
}

function sv_other_setting_page() {

}

add_action( 'admin_init', 'sv_admin_settings' );
function sv_admin_settings() {
	register_setting( 'main_sv_options', 'sv_main_settings' );
}

if ( is_admin() ) {
	add_action( 'admin_init', 'register_mysettings' );
}

function register_mysettings() { // whitelist options
	register_setting( 'main_sv_options', 'new_option_name' );
	register_setting( 'main_sv_options', 'max_posts_no' );
}