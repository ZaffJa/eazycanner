<?php if ( has_post_thumbnail() ) : ?>
<a href="<?php the_permalink(); ?>">
<?php the_post_thumbnail( 'large', array( 'class' => 'mb16' ) ); ?>
</a>
<?php endif; ?>