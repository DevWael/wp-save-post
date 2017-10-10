<div class="sv-post-container sv-post-<?php the_ID() ?>" data-id="<?php the_ID() ?>">
	<div class="sv-post-control">
		<button type="button" title="Delete" data-control="delete" data-post-id="<?php the_ID() ?>" data-nonce="<?php echo wp_create_nonce( 'sv_save_post' ); ?>">
			<i class="fa fa-times-circle" aria-hidden="true"></i>
		</button>
	</div>
	<div class="sv-post-image">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail('small'); ?>
		</a>
	</div>
	<div class="sv-post-content">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_title(); ?>
		</a>
	</div>
    <div class="clearfix"></div>
</div>
