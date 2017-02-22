<section class="p0">
    <div class="container">
        <div class="row">
            <div id="main-content" class="col-md-9">
                <?php get_template_part( 'templates/post/inc', 'loader' ); ?>
                <div class="row masonry masonry-show mb40">
                    <?php 
                	if ( have_posts() ) : 
                        while ( have_posts() ) : the_post();
                    		get_template_part( 'templates/post/inc', 'masonry-2col' );
                    	endwhile;	
                	else :
                		get_template_part( 'templates/post/content', 'none' );
                	endif;
                    ?>
                </div>
                <div class="row">
                    <?php echo function_exists('roneous_pagination') ? roneous_pagination() : posts_nav_link(); ?>
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>