<?php 
$testimonial_url = get_post_meta( $post->ID, '_tlg_testimonial_url', 1 );
$testimonial_content = get_post_meta( $post->ID, '_tlg_testimonial_content', 1 );
$testimonial_info = get_post_meta( $post->ID, '_tlg_testimonial_info', 1 );
?>
<li class="item">
	<?php echo $testimonial_content ? '<div class="quote content xss-text">'.esc_attr( $testimonial_content ).'</div>' : ''; ?>
    <div class="quote-author image-round-100">
        <?php the_post_thumbnail(); ?>
    	<h6 class="uppercase">
    	<?php 
    	if( !filter_var( $testimonial_url, FILTER_VALIDATE_URL ) === false || $testimonial_url == '#' ) {
		    echo '<a href="'. esc_url($testimonial_url) .'">'.get_the_title().'</a>';
		} else {
		    echo get_the_title();
		}
    	?>
    	</h6>
    	<?php echo $testimonial_info ? '<span class="droid-text">'.esc_attr( $testimonial_info ).'</span>' : ''; ?>
    </div>
</li>