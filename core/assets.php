<?php
/**
 * Load all plugin scripts
 */

add_action( 'wp_enqueue_scripts', 'sv_save_post_assets_load' );
function sv_save_post_assets_load() {

	//Load JS Files
	wp_enqueue_script( 'sv_ajax_system', SV_JS_URI . 'ajax.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'sv_ajax_system', 'sv_ajax_object',
		array( 'sv_ajax_url' => admin_url( 'admin-ajax.php' ) ) );

}