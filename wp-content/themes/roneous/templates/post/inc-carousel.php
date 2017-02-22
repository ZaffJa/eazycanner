<?php
if( !has_post_thumbnail() ) return false;
?>
<div class="masonry-item project post-carousel box-zoom ">
    <div class="box-inner">
        <div class="box-inner__i">
            <div class="box-pic">
                <?php the_post_thumbnail( 'roneous_grid', array('class' => 'background-image') ); ?>
                <div class="box-mask">
                    <a href="<?php the_permalink(); ?>">
                        <div class="mask-content text-center">
                            <h1 class="mask-content__title"><?php the_title(); ?></h1>
                            <div class="mask-content__meta"><?php echo get_the_time(get_option('date_format')); ?></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>