<div id="main-content" class="col-sm-10 col-sm-offset-1">
    <div class="post-wrap mb0 overflow-visible">
        <div class="inner-wrap">
            <?php get_template_part( 'templates/post/inc', 'header-single' ); ?>
            <div class="post-content">
                <?php 
                if ( has_post_thumbnail() && 'yes' == get_option( 'roneous_blog_show_feature', 'no' ) ) {
                    the_post_thumbnail( 'full', array( 'class' => 'mb16' ) );
                }
                the_content(); wp_link_pages(); 
                ?>
            </div>
        </div>
        <div class="mt16 pb48 overflow-hidden">
            <div class="pull-left">
                <?php echo roneous_like_display( 'round' ); ?>
                <?php get_template_part( 'templates/post/inc', 'sharing' ); ?>
            </div>
            <div class="pull-right"><?php the_tags( '', ' ', '' ); ?></div>
        </div>
    </div>
    <?php comments_template(); ?>
</div>