<section class="p0">
    <div class="container">
        <div class="row">
            <div id="main-content" class="col-md-9 mb-xs-24">
            	<?php 
        		if ( have_posts() ) : 
                    while ( have_posts() ) : the_post();
            			get_template_part( 'templates/post/content', 'search' );
            		endwhile;
        		else :
        			get_template_part( 'templates/post/content', 'none' );
        		endif;
        		echo function_exists('roneous_pagination') ? roneous_pagination() : posts_nav_link();
            	?>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>