<?php global $wp_query; ?>
<section class="p0 sidebar-left">
	<div class="container">
		<div class="row">
			<?php get_sidebar(); ?>
			<div id="main-content" class="col-md-9 col-sm-12">
				<div class="grid-blog row mb40">
				    <?php 
			    	if ( have_posts() ) : 
			    		while ( have_posts() ) : the_post();
				    		if( $wp_query->current_post % 2 == 0 && !( $wp_query->current_post == 0 ) ){
				    			echo '</div><div class="row mb40">';
				    		}
				    		get_template_part( 'templates/post/inc', 'grid-2col' );
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
		</div>
	</div>
</section>