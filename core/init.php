<?php

/**
 * Plugin core functionality
 */

require SV_CORE_DIR . 'post-template.php';

/**
 * Handle ajax requests when not logged in and save data into a cookie
 */
add_action( 'wp_ajax_nopriv_sv_post_id', 'sv_handle_posts_in_cookie' );
function sv_handle_posts_in_cookie() {
	//todo Handle ajax requests when not logged in and save data into a cookie
}

/**
 * Handle ajax requests when the user is logged in and save data into user meta
 */
add_action( 'wp_ajax_sv_post_id', 'sv_handle_posts_in_usermeta' );
function sv_handle_posts_in_usermeta() {
	//Security check
	ob_start();
	sv_save_post_button();
	$delete_button = ob_get_clean();
	ob_end_clean();
	ob_start();
	sv_delete_post_button();
	$add_button = ob_get_clean();
	ob_end_clean();
	if ( ! isset( $_POST['nonce'] ) ) {
		wp_send_json_error( 'Nonce is missing' );
	}
	if ( ! wp_verify_nonce( $_POST['nonce'], 'sv_save_post' ) ) {
		wp_send_json_error( 'Bad nonce' );
	}
	$current_user = get_current_user_id();
	//delete_user_meta($current_user, 'sv_post_ids'); //refreshing user meta for testing only
	$saved_posts = (array) get_user_meta( $current_user, 'sv_post_ids', true );

	if ( isset( $_POST['control'] ) && $_POST['control'] === 'add' ) {
		//wp_send_json_success( $saved_posts);
		if ( isset( $_POST['post_id'] ) && is_numeric( $_POST['post_id'] ) && sv_check_post_exist_by_id( $_POST['post_id'] ) ) {
			//Make the (Add) process
			if ( ! in_array( $_POST['post_id'], $saved_posts ) ) {
				$saved_posts[] = $_POST['post_id'];
				update_user_meta( $current_user, 'sv_post_ids', $saved_posts );
				wp_send_json_success( array(
					'saved_posts' => $saved_posts,
					'message'     => 'added',
					'button'      => $add_button
				) ); //Send add post command to the frontend
			} else {
				wp_send_json_success( array(
					'message' => 'the post is existing',
					'button'  => $delete_button
				) );
			}
		} else {
			//(Validation error) sending error message ToDo make the error message
			wp_send_json_error( 'some error (failed to validate or the post with the given ID is not exist)' );
		}
	} elseif ( isset( $_POST['control'] ) && $_POST['control'] === 'delete' ) {
		//Delete Mechanism
		$key = array_search( $_POST['post_id'], $saved_posts );
		if ( $key !== false ) {
			unset( $saved_posts[ $key ] );
			update_user_meta( $current_user, 'sv_post_ids', $saved_posts );
			wp_send_json_success( array(
				'post_id' => $_POST['post_id'],
				'button'  => $delete_button
			) ); //Send delete command to the frontend
		} else {
		    //the post is no longer exist, send the add button
			wp_send_json_success( array(
				'saved_posts' => $saved_posts,
				'message'     => 'added',
				'button'      => $add_button
			) );
		}
	}
}

add_action( 'init', 'sv_move_posts_from_cookie_to_usermeta' );
function sv_move_posts_from_cookie_to_usermeta() {
	//todo move post ids from cookie to user meta (sv_post_ids)
}

function sv_check_post_exist_by_id( $id ) {
	return is_string( get_post_status( $id ) );
}

function sv_save_post_button() {
	?>
    <button type="button" class="sv-save-post sv-control-btn" data-control="add"
            data-nonce="<?php echo wp_create_nonce( 'sv_save_post' ); ?>" data-post-id="<?php the_ID(); ?>">
        save this post
    </button>
	<?php
}

function sv_delete_post_button() {
	?>
    <button type="button" class="sv-delete-btn sv-control-btn" title="Delete" data-control="delete"
            data-post-id="<?php the_ID(); ?>"
            data-nonce="<?php echo wp_create_nonce( 'sv_save_post' ); ?>">
        <i class="fa fa-times-circle" aria-hidden="true"></i>
    </button>
	<?php
}

add_action( 'sv_render_save_posts_button', 'sv_render_save_posts_button' );
function sv_render_save_posts_button() {
	$post_id = get_the_ID();
	if ( is_user_logged_in() ) {
		//check if the post is saved in post meta
		$current_user = get_current_user_id();
		$saved_posts  = (array) get_user_meta( $current_user, 'sv_post_ids', true );
		if ( in_array( $post_id, $saved_posts ) ) {
			//the post is existing, show the delete button
			sv_delete_post_button();
		} else {
			//the post is not found in the save posts list, show the (Add button)
			sv_save_post_button();
		}
	} else {
		//ToDo check if the post is saved in cookies
	}
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
						sv_post_template();
					}
				}
				wp_reset_postdata();
				?>
            </div>
			<?php
		} else {
			//todo no posts message
		}

	} else {
		//todo get posts ids from saved in cookie
	}
}

add_shortcode( 'sv_saved_posts', 'sv_short_code' );
function sv_short_code() {
	sv_view_saved_posts();
}

function sv_display_saved_posts_in_user_profile() {

}