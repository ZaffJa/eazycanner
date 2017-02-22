<section class="image-bg bg-dark parallax project-parallax overlay z-index pt64 pb64">
    <div class="background-content">
        <?php the_post_thumbnail( 'full', array('class' => 'background-image') ); ?>
        <div class="background-overlay"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title('<h4 class="xs-text-mobile uppercase mb8">', '</h4><h6 class="s-text-mobile uppercase">'. roneous_the_terms( 'portfolio_category', ' / ', 'name' ) .'</h6>'); ?>
                </a>
            </div>
        </div>
    </div>
</section>