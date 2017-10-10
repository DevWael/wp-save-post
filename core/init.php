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
	if ( ! isset( $_POST['nonce'] ) ) {
		wp_send_json_error( 'Nonce is missing' );
	}
	if ( ! wp_verify_nonce( $_POST['nonce'], 'sv_save_post' ) ) {
		wp_send_json_error( 'Bad nonce' );
	}
	$current_user = get_current_user_id();
	$saved_posts  = get_user_meta( $current_user, 'sv_post_ids', true );
	if ( isset( $_POST['control'] ) && $_POST['control'] === 'add' ) {
		if ( isset( $_POST['post_id'] ) && is_numeric( $_POST['post_id'] ) && sv_check_post_exist_by_id( $_POST['post_id'] ) ) {
			if ( ! in_array( $_POST['post_id'], $saved_posts ) ) {
				$saved_posts[] = $_POST['post_id'];
				update_user_meta( $current_user, 'sv_post_ids', $saved_posts );
			}
		}
		wp_send_json_success( $saved_posts ); //Send add post command to the frontend
	} elseif ( isset( $_POST['control'] ) && $_POST['control'] === 'delete' ) {
		//Delete Mechanizm
		$key = array_search( $_POST['post_id'], $saved_posts );
		if ( $key !== false ) {
			unset( $saved_posts[ $key ] );
		}
		update_user_meta( $current_user, 'sv_post_ids', $saved_posts );
		wp_send_json_success( $saved_posts ); //Send delete command to the frontend
	}
}

add_action( 'init', 'sv_move_posts_from_cookie_to_usermeta' );
function sv_move_posts_from_cookie_to_usermeta() {

}

function sv_check_post_exist_by_id( $id ) {
	return is_string( get_post_status( $id ) );
}

add_action( 'sv_render_save_posts_button', 'sv_render_save_posts_button' );
function sv_render_save_posts_button() {
	?>
    <button type="button" class="sv-save-post" data-control="add"
            data-nonce="<?php echo wp_create_nonce( 'sv_save_post' ); ?>" data-post-id="<?php the_ID(); ?>">
        save this post
    </button>
	<?php
}

add_action( 'sv_render_posts_list', 'sv_view_saved_posts' );
function sv_view_saved_posts() {
	if ( is_user_logged_in() ) {
		//get posts ids from user meta
		$current_user = get_current_user_id();
		$saved_posts  = get_user_meta( $current_user, 'sv_post_ids', true );
		if ( $saved_posts && is_array( $saved_posts ) ) {
			?>
            <div class="sv-posts-container">
				<?php
				$args  = array(
					'post__in'               => array_reverse( $saved_posts ),
					'no_found_rows'          => true,  // counts posts, remove if pagination required
					'update_post_term_cache' => false, // grabs terms, remove if terms required (category, tag...)
					'update_post_meta_cache' => false  // grabs post meta, remove if post meta required
				);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						//Render html posts file here
						$query->the_post();
						require SV_CORE_DIR . 'post-template.php';
					}
				}
				wp_reset_postdata();
				?>
            </div>
			<?php
		} else {
			//no posts message
		}

	} else {
		//get posts ids from saved in cookie
	}
}

function sv_display_saved_posts_in_user_profile(){

}