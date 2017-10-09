<?php

/**
 * Plugin core functionality
 */

/**
 * Handle ajax requests when not logged in and save data into a cookie
 */
add_action( 'wp_ajax_nopriv_sv_post_id', 'sv_handle_posts_in_cookie' );
function sv_handle_posts_in_cookie() {
	//Handle ajax requests when not logged in and save data into a cookie
}

/**
 * Handle ajax requests when the user is logged in and save data into user meta
 */
add_action( 'wp_ajax_sv_post_id', 'sv_handle_posts_in_usermeta' );
function sv_handle_posts_in_usermeta() {
	//Security check
	$saved_posts = array( );
	if ( ! isset( $_POST['nonce'] ) ) {
		wp_send_json_error( 'Nonce is missing' );
	}
	if ( ! wp_verify_nonce( $_POST['nonce'], 'sv_save_post' ) ) {
		wp_send_json_error( 'Bad nonce' );
	}
	$current_user = get_current_user_id();
	$saved_posts  = get_user_meta( $current_user, 'sv_post_ids',true );
	if ( isset( $_POST['post_id'] ) && is_numeric( $_POST['post_id'] ) && sv_check_post_exist_by_id( $_POST['post_id'] ) ) {
		if ( ! in_array( $_POST['post_id'], $saved_posts ) ) {
			$saved_posts[] = $_POST['post_id'];
			update_user_meta( $current_user, 'sv_post_ids', $saved_posts );
		}
	}
//	delete_user_meta($current_user, 'sv_post_ids');
	wp_send_json_success( $saved_posts );
}

add_action( 'init', 'sv_move_posts_from_cookie_to_usermeta' );
function sv_move_posts_from_cookie_to_usermeta() {

}

function sv_check_post_exist_by_id( $id ) {
	return is_string( get_post_status( $id ) );
}