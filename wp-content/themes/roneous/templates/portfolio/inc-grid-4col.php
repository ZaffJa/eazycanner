<div class="col-md-3 col-sm-6 project" data-filter="<?php echo esc_html__( 'All', 'roneous' ).','.roneous_the_terms( 'portfolio_category', ',', 'name' ); ?>" 
		data-groups='["<?php echo roneous_the_terms( 'portfolio_category', '","', 'slug' ); ?>"]'>
    <div class="image-box hover-block text-center">
        <?php the_post_thumbnail( 'roneous_box', array('class' => 'background-image') ); ?>
        <div class="hover-state">
            <a href="<?php the_permalink(); ?>">
                <?php the_title('<h4 class="mx-text mb8">', '</h4><h6>'. roneous_the_terms( 'portfolio_category', ' / ', 'name' ) .'</h6>'); ?>
            </a>
        </div>
    </div>
</div>