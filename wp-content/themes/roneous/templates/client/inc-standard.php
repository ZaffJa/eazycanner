<?php global $post;  $client_url = get_post_meta( $post->ID, '_tlg_client_url', true ); ?>
<div class="col-sm-3 text-center mb48 mb-xs-16">
	<div class="inline-block" data-toggle="tooltip" data-placement="top" title="<?php the_title(); ?>" data-original-title="<?php the_title(); ?>">
		<?php
		if( $client_url ) echo '<a href="'. esc_url( $client_url ) .'" target="_blank">';
		the_post_thumbnail( 'full', array('class' => 'image-s mb-xs-8 fade-35') );
		if( $client_url ) echo '</a>';
		?>
	</div>
</div>