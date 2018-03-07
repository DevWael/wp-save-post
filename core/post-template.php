<?php
add_filter( 'render_post_template', 'sv_post_template', 10, 2 );
function sv_post_template( $p_id = '', $echo = false ) {
	if ( empty( $p_id ) ) {
		$p_id = get_the_ID();
	}

	$post_thumb = ( has_post_thumbnail( $p_id ) ) ?
		'<div class="sv-post-image">
                <a href="' . get_the_permalink( $p_id ) . '" title="' . get_the_title( $p_id ) . '">
					' . get_the_post_thumbnail( $p_id, 'small' ) . '
                </a>
            </div>' : ' ';


	$post_html = '<div class="sv-post-container sv-post-' . $p_id . '" data-id="' . $p_id . '">
        <div class="sv-post-control">
            <button type="button" title="Delete" data-control="delete" data-post-id="' . $p_id . '"
                    data-nonce="' . wp_create_nonce( 'sv_save_post' ) . '">
                <i class="fa fa-times-circle" aria-hidden="true"></i>
            </button>
        </div>' . $post_thumb .
	             '<div class="sv-post-content">
            <a href="' . get_the_permalink( $p_id ) . '" title="' . get_the_title( $p_id ) . '">
				' . get_the_title( $p_id ) . '
            </a>
        </div>
        <div class="clearfix"></div>
    </div>';
	if ( $echo ) {
		echo $post_html;
	} else {
		return $post_html;
	}

}