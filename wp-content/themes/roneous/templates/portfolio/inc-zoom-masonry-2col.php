<div class="col-sm-6 masonry-item masonry-item project box-zoom" data-filter="<?php echo esc_html__( 'All', 'roneous' ).','.roneous_the_terms( 'portfolio_category', ',', 'name' ); ?>" 
		data-groups='["<?php echo roneous_the_terms( 'portfolio_category', '","', 'slug' ); ?>"]'>
    <div class="box-inner">
        <div class="box-inner__i">
            <div class="box-pic">
                <?php the_post_thumbnail( 'full', array('class' => 'background-image') ); ?>
                <div class="box-mask">
                    <a href="<?php the_permalink(); ?>">
                        <div class="mask-content text-center">
                            <h2 class="mask-content__title title-small"><?php the_title(); ?></h2>
                            <div class="mask-content__meta"><?php echo roneous_the_terms( 'portfolio_category', ' / ', 'name' ); ?></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>