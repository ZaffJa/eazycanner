<section class="p0 text-left">
    <div class="blog-carousel blog-carousel-detail three-columns">
    	<?php
		if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'templates/post/inc', 'carouseldetail' );
		    endwhile;
		else :
			get_template_part( 'templates/post/content', 'none' );
		endif;
    	?>
    </div>
</section>