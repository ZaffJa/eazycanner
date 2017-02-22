<section class="projects pt48">
    <div class="container">
        <?php $project_id = uniqid( "project_grid_" ); ?>
        <div class="row pb24">
            <div class="col-sm-12 text-center">
                <ul class="filters mb0" data-project-id="<?php echo esc_attr($project_id) ?>"></ul>
            </div>
        </div>
        <?php get_template_part( 'templates/post/inc','loader' ); ?>
        <div id="<?php echo esc_attr($project_id) ?>" data-id="<?php echo esc_attr($project_id) ?>" class="row masonry masonry-show project-content project-masonry">
            <?php 
            if ( have_posts() ) : 
                while ( have_posts() ) : the_post();
                    get_template_part( 'templates/portfolio/inc', 'masonry-2col' );
                endwhile;
            else :
                get_template_part( 'templates/post/content', 'none' );
            endif;
            ?>
        </div>
    </div>
</section>