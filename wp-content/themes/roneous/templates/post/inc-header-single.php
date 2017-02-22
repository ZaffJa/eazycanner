<div class="entry-data entry-data-big mb30">
	<figure class="entry-data-author">
		<?php echo get_avatar( get_the_author_meta('ID') , 70 ); ?>
	</figure>
	<div class="entry-data-summary">
		<span class="inline-block author-name mb3"><?php esc_html_e( 'By ', 'roneous' ); ?><?php the_author_posts_link() ?></span>
		<div class="display-block mb3">
			<span class="inline-block"><?php printf( '%1$s', get_the_date( 'M d, Y' ) ); ?></span>
			<?php if ( !post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
				<span class="middot-divider dot"></span>
				<span class="inline-block"><?php comments_popup_link( esc_html__( 'Leave a comment', 'roneous' ), esc_html__( '1 Comment', 'roneous' ), esc_html__( '% Comments', 'roneous' ) ); ?></span>
			<?php endif; ?>
		</div>
		<?php if ( has_category() ) : ?>
			<span class="inline-block"><span><?php esc_html_e( ' in ', 'roneous' ); ?></span><?php the_category( ',</span><span class="inline-block">' ) ?></span>
		<?php endif; ?>
	</div>
</div>