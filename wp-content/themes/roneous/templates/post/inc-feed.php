<?php 
$sticky = is_sticky() ? '<span class="featured-stick">'.esc_html__( 'Featured', 'roneous' ).'</span>' : '';
$format = get_post_format(); 
?>
<div class="feed-item text-center pt48 pt-xs-0">
    <div class="row mb8 mb-xs-0">
        <div class="col-md-8 col-md-offset-2">
            <h6 class="entry-meta mb16 mb-xs-8"><?php echo get_the_time(get_option('date_format')) ?></h6>
            <?php the_title('<h4 class="uppercase normal-font"><a class="link-dark-title" href="'. esc_url(get_permalink()) .'">'.$sticky, '</a></h4>'); ?>
        </div>
    </div>
    <div class="row mb8 mb-xs-16">
        <div class="col-md-8 col-md-offset-2 clearfloat">
            <?php get_template_part( 'templates/post/format', $format ); ?>
            <div class="entry-meta mb8 mt-xs-32">
                <?php if ( !post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
                    <span class="inline-block">
                        <span class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'roneous' ), esc_html__( '1 Comment', 'roneous' ), esc_html__( '% Comments', 'roneous' ) ); ?></span>
                    </span>
                <?php endif; ?>
                <?php if ( has_category() ) : ?>
                    <span class="inline-block"><span><?php esc_html_e( 'in', 'roneous' ); ?></span><?php the_category( ',</span><span class="inline-block">' ) ?></span>
                <?php endif; ?>
            </div>
        	<?php if( 'quote' != $format && 'link' != $format ) the_excerpt(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <span class="read-more"><a href="<?php the_permalink(); ?>"><span data-hover="<?php esc_html_e( 'Read More', 'roneous' ); ?>"><?php esc_html_e( 'Read More', 'roneous' ); ?></span></a></span>
            <span class="middot-divider"></span>
            <?php echo roneous_like_display(); ?>
        </div>
    </div>
    <hr>
</div>