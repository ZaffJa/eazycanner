<section class="image-bg bg-dark parallax project-parallax overlay z-index pt120 pb120">
    <div class="background-content">
        <?php the_post_thumbnail( 'full', array('class' => 'background-image') ); ?>
        <div class="background-overlay"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <?php the_title( '<h3 class="xs-text-mobile uppercase mb8">', '</h3>' ); ?>
                <p class="lead"><?php echo get_post_meta( $post->ID, '_tlg_the_subtitle', true ); ?></p>
                <a class="btn btn-lg btn-rounded btn-white mb0 mt24" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Open Project','roneous' ); ?></a>
            </div>
        </div>
    </div>
</section>