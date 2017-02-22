<?php $sticky = is_sticky() ? '<span class="featured-stick">'.esc_html__( 'Featured', 'roneous' ).'</span>' : ''; ?>
<div class="post-title">
    <?php the_title('<h4><a class="link-dark-title" href="'. esc_url(get_permalink()) .'">'.$sticky, '</a></h4>'); ?>
</div>
<div class="entry-meta mt8 mb16 p0">
	<span class="inline-block hide"><i class="ti-timer"></i><?php printf( '%1$s', get_the_date() ); ?></span>
	<span class="inline-block"><i class="ti-user"></i><span><?php esc_html_e( 'by', 'roneous' ); ?></span><?php the_author_posts_link() ?></span>
	<?php if ( has_category() ) : ?>
		<span class="inline-block"><i class="ti-folder"></i><span><?php esc_html_e( 'in', 'roneous' ); ?></span><?php the_category( ',</span><span class="inline-block">' ) ?></span>
	<?php endif; ?>
	<?php if ( ! post_password_required() && ( comments_open() && get_comments_number() ) ) : ?>
		<span class="inline-block"><i class="ti-comment"></i><?php comments_popup_link( esc_html__( '0 Comment', 'roneous' ), esc_html__( '1 Comment', 'roneous' ), esc_html__( '% Comments', 'roneous' ) ); ?></span>
	<?php endif; ?>
</div>