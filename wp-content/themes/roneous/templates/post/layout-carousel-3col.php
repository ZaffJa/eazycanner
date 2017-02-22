<section class="p0 bg-dark">
    <div class="blog-carousel three-columns">
    	<?php
		if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'templates/post/inc', 'carousel' );
		    endwhile;
		else :
			get_template_part( 'templates/post/content', 'none' );
		endif;
    	?>
    </div>
</section>