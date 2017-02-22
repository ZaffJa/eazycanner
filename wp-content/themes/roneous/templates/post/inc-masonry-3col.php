<?php
$sticky = is_sticky() ? '<span class="featured-stick">'.esc_html__( 'Featured', 'roneous' ).'</span>' : '';
$format = get_post_format();
?>
<div class="col-sm-4 post-wrap masonry-item mb48">
    <?php get_template_part( 'templates/post/format', $format ); ?>
    <div class="inner">
    	<div class="inner-wrap">
    		<a href="<?php the_permalink(); ?>">
	            <?php the_title('<h5 class="blog-title mb0">'.$sticky, '</h5>'); ?>
	        </a>
	        <div class="entry-meta mt8 mb16 p0">
	        	<span class="inline-block"><?php echo get_the_time(get_option('date_format')) ?></span>
	        	<span class="inline-block"><span><?php esc_html_e( 'by', 'roneous' ); ?></span><?php the_author_posts_link() ?></span>
	        	<?php if ( has_category() ) : ?>
	        		<span class="inline-block"><span><?php esc_html_e( 'in', 'roneous' ); ?></span><?php the_category( ',</span><span class="inline-block">' ) ?></span>
	        	<?php endif; ?>
	        </div>
	        <?php if( 'quote' != $format && 'link' != $format ) the_excerpt(); ?>
	        <span class="pull-left read-more"><a href="<?php the_permalink(); ?>"><span data-hover="<?php esc_html_e( 'Read More', 'roneous' ); ?>"><?php esc_html_e( 'Read More', 'roneous' ); ?></span></a></span>
	        <span class="pull-right">
				<?php echo roneous_like_display(); ?>
				<?php if ( !post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
					<span class="middot-divider"></span>
					<span class="comments-link"><?php comments_popup_link( '<i class="ti-comment"></i><span>0</span>', '<i class="ti-comment"></i><span>1</span>', '<i class="ti-comment"></i><span>%</span>' ); ?></span>
				<?php endif; ?>
			</span>
    	</div>
    </div>
</div>