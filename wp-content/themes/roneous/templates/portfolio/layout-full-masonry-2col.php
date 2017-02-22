<section class="projects p0">
    <?php $project_id = uniqid( "project_grid_" ); ?>
    <div class="center-absolute">
        <ul class="filters center-absolute-inner box-shadow mb0" data-project-id="<?php echo esc_attr($project_id) ?>"></ul>
    </div>
    <div class="container container-l">
        <?php get_template_part( 'templates/post/inc','loader' ); ?>
        <div id="<?php echo esc_attr($project_id) ?>" data-id="<?php echo esc_attr($project_id) ?>" class="row masonry masonry-show project-content project-masonry-full">
            <?php 
            if ( have_posts() ) : 
                while ( have_posts() ) : the_post();
                    get_template_part( 'templates/portfolio/inc', 'full-masonry-2col' );
                endwhile;
            else :
                get_template_part( 'templates/post/content', 'none' );
            endif;
            ?>
        </div>
    </div>
</section>