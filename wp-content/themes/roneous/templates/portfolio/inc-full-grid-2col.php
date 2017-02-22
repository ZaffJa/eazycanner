<div class="col-sm-6 project" data-filter="<?php echo esc_html__( 'All', 'roneous' ).','.roneous_the_terms( 'portfolio_category', ',', 'name' ); ?>" 
		data-groups='["<?php echo roneous_the_terms( 'portfolio_category', '","', 'slug' ); ?>"]'>
    <div class="image-box hover-block text-center">
        <?php  
        $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
        $url = wp_get_attachment_image_src($post_thumbnail_id, 'full');
		if ( isset($url[0]) && $url[0] ) {
			$image = roneous_resize_image($url[0], 1000, 800, true);
	    	echo $image ? '<img class="background-image" src="'. esc_url($image) .'" alt="'.esc_html__( 'project-item', 'roneous' ).'" />' : '';
		}
        ?>
        <div class="hover-state">
            <a href="<?php the_permalink(); ?>">
                <?php the_title('<h4 class="mx-text mb8">', '</h4><h6>'. roneous_the_terms( 'portfolio_category', ' / ', 'name' ) .'</h6>'); ?>
            </a>
        </div>
    </div>
</div>