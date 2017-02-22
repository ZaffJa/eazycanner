<?php global $post; $client_url = get_post_meta( $post->ID, '_tlg_client_url', true ); ?>
<li class="text-center">
    <?php 
	if( $client_url ) echo '<a href="'. esc_url( $client_url ) .'" target="_blank">';
	the_post_thumbnail( 'full', array('class' => 'image-s') );
	if( $client_url ) echo '</a>';
    ?>
</li>