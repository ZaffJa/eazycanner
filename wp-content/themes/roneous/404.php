<?php get_header(); ?>
<section class="fullscreen">
    <div class="container vertical-alignment">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="text-center">
                    <h1 class="behind"><i class="ti-unlink"></i></h1>
                    <h1 class="large"><strong><?php esc_html_e( '404', 'roneous' ); ?></strong><?php esc_html_e( 'Nothing was found','roneous' ); ?></h1>
                    <div class="search-wrap">
                        <?php get_template_part( 'templates/post/content', 'none' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer();