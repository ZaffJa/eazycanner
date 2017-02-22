<?php if ( post_password_required() ) return; ?>

<div class="comments" id="comments">
    <?php if( have_comments() ) : ?>
		<h6 class="widgettitle">
    		<?php comments_number( esc_html__( '0 Comment', 'roneous' ), esc_html__( 'There is 1 comment on this post', 'roneous' ), esc_html__( 'There are % comments on this post', 'roneous' ) ); ?>
    	</h6>
		<ul id="singlecomments" class="comments-list">
			<?php wp_list_comments( 'type=comment&callback=roneous_comment' ); ?>
		</ul>
	<?php endif;
	paginate_comments_links();
	if ( comments_open() ) {
		comment_form(
			array(
				'fields' => apply_filters( 'comment_form_default_fields', array(
				    'author' => '<input type="text" id="author" name="author" placeholder="' . esc_html__( 'Name *', 'roneous' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" />',
				    'email'  => '<input name="email" type="text" id="email" placeholder="' . esc_html__( 'Email *', 'roneous' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" />',
				    'url'    => '<input name="url" type="text" id="url" placeholder="' . esc_html__( 'Website', 'roneous' ) . '" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" />')
				),
				'comment_field' 		=> '<textarea name="comment" placeholder="' . esc_html__( 'Your Comment Here', 'roneous' ) . '" id="comment" aria-required="true" rows="3"></textarea>',
				'cancel_reply_link' 	=> esc_html__( 'Cancel' , 'roneous' ),
				'comment_notes_before' 	=> '',
				'comment_notes_after' 	=> '',
				'label_submit' 			=> esc_html__( 'Submit' , 'roneous' )
			)
		);
	} else { ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'roneous' ) ?></p>
	<?php } ?>
</div>