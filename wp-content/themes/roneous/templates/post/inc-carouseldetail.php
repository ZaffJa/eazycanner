<?php
$format = get_post_format();
if( !has_post_thumbnail() || 'quote' == $format || 'link' == $format ) return false;
?>
<div class="post-wrap project">
    <div class="inner-wrap border-none p0">
        <a href="<?php the_permalink(); ?>">
            <div class="post-image bg-overlay mb16">
                <?php the_post_thumbnail( 'roneous_grid', array('class' => 'background-image') ); ?>
                <div class="bg-mask"><i class="ti-plus"></i></div>
            </div>
        </a>
        <div class="inner-left inner-small">
            <div class="day"><?php echo get_the_time('d') ?></div>
            <div class="month"><?php echo get_the_time('M') ?></div>
        </div>
        <div class="inner-right inner-small">
            <div class="post-title">
                <?php the_title('<h5 class="mb0"><a class="link-dark-title" href="'. esc_url(get_permalink()) .'">', '</a></h5>'); ?>
            </div>
            <div class="entry-meta mt8 mb16 p0">
                <?php if ( has_category() ) : ?>
                    <span class="inline-block"><span><?php esc_html_e( 'in', 'roneous' ); ?></span><?php the_category( ',</span><span class="inline-block">' ) ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php the_excerpt(); ?>
    </div>
</div>