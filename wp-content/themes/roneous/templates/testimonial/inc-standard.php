<?php 
$testimonial_url = get_post_meta( $post->ID, '_tlg_testimonial_url', 1 );
$testimonial_content = get_post_meta( $post->ID, '_tlg_testimonial_content', 1 );
$testimonial_info = get_post_meta( $post->ID, '_tlg_testimonial_info', 1 );
?>
<div class="col-sm-4">
    <div class="feature boxed image-round-100">
    	<?php the_post_thumbnail( 'full', array('class' => 'image-small inline-block mb24') ); ?>
    	<?php echo $testimonial_content ? '<div class="quote content xss-text">'.esc_attr( $testimonial_content ).'</div>' : ''; ?>
    	<div class="fade-75 mt16 display-block">
    		<h6 class="uppercase inline-block">
            <?php 
            if( !filter_var( $testimonial_url, FILTER_VALIDATE_URL ) === false || $testimonial_url == '#' ) {
                echo '<a class="author-link" href="'. esc_url($testimonial_url) .'">'.get_the_title().'</a>';
            } else {
                echo get_the_title();
            }
            ?>                
            </h6>
    		<?php echo $testimonial_info ? '<span class="droid-text">- '.esc_attr( $testimonial_info ).'</span>' : ''; ?>
    	</div>
    </div>
</div>