<section class="fullscreen image-bg overlay parallax project-parallax">
    <div class="background-content">
        <?php the_post_thumbnail( 'full', array('class' => 'background-image') ); ?>
        <div class="background-overlay"></div>
    </div>
    <div class="container vertical-alignment text-center">
        <?php the_title('<h2 class="xs-text-mobile uppercase mb8">', '</h2><h4 class="s-text-mobile uppercase">'. roneous_the_terms( 'portfolio_category', ' / ', 'name' ) .'</h4>'); ?>
        <a class="btn btn-white btn-lg btn-rounded mt16 mb0" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Open Project','roneous' ); ?></a>
    </div>
</section>