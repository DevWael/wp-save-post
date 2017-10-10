<?php
/**
 * Admin Dashboard goes here
 */

add_action( 'admin_menu', 'sv_admin_menu_pages' );
function sv_admin_menu_pages() {
	add_menu_page( 'Main setting', 'WP Save Posts', 'manage_options', 'sv_main_setting_page', 'sv_main_setting_page', 'dashicons-tickets', 40);


	add_submenu_page( 'sv_main_setting_page', 'other settings', 'Other Settings', 'manage_options', 'sv_other_setting_page', 'sv_other_setting_page' );
}

function sv_main_setting_page() {
	require SV_ADMIN_DIR . 'main-setting-template.php';
}

function sv_other_setting_page() {

}