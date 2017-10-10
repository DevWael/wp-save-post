<div class="wrap">
    <h1>WP Save posts</h1>
    <p>Save posts to read them later</p>
    <form method="post" action="options.php">
		<?php settings_fields( 'main_sv_options' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">New Option Name</th>
                <td><input type="text" name="new_option_name"
                           value="<?php echo esc_attr( get_option( 'new_option_name' ) ); ?>"/></td>
            </tr>

            <tr valign="top">
                <th scope="row">Maximum number of saved posts per user</th>
                <td><input type="number" name="max_posts_no"
                           value="<?php echo esc_attr( ( get_option( 'max_posts_no' ) ) ? get_option( 'max_posts_no' ) : 8 ); ?>"/>
                </td>
            </tr>
        </table>
		<?php submit_button(); ?>
    </form>
</div>