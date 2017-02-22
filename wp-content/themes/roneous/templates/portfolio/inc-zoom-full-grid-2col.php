<div class="col-sm-6 project box-zoom" data-filter="<?php echo esc_html__( 'All', 'roneous' ).','.roneous_the_terms( 'portfolio_category', ',', 'name' ); ?>" 
		data-groups='["<?php echo roneous_the_terms( 'portfolio_category', '","', 'slug' ); ?>"]'>
    <div class="box-inner">
        <div class="box-inner__i">
            <div class="box-pic">
                <?php  
                $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
                $url = wp_get_attachment_image_src($post_thumbnail_id, 'full');
                if ( isset($url[0]) && $url[0] ) {
                    $image = roneous_resize_image($url[0], 1000, 800, true);
                    echo $image ? '<img class="background-image" src="'. esc_url($image) .'" alt="'.esc_html__( 'project-item', 'roneous' ).'" />' : '';
                }
                ?>
                <div class="box-mask">
                    <a href="<?php the_permalink(); ?>">
                        <div class="mask-content text-center">
                            <h2 class="mask-content__title"><?php the_title(); ?></h2>
                            <div class="mask-content__meta"><?php echo roneous_the_terms( 'portfolio_category', ' / ', 'name' ); ?></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>