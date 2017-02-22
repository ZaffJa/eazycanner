<?php
if ( has_post_thumbnail() ) the_post_thumbnail( 'full', array( 'class' => 'mb0' ) );
if( get_post_meta($post->ID, '_tlg_the_audio_oembed', 1) ) {
	echo wp_oembed_get(get_post_meta($post->ID, '_tlg_the_audio_oembed', 1), array('class' => 'clearfix mb16'));
} else {
	// Get audio embed in post content
	$reg = preg_match('#^(<p>)?.*(http://.*/.*\.mp3).*(</p>|<br />)?#im', get_the_content(), $matches );
	if( isset($matches[2]) ) {
		echo '<div class="clearfix mb16">'.
			wp_audio_shortcode( array( 'src' => $matches[2], 'loop' => '', 'autoplay' => '', 'preload' => 'auto' ) ).'</div>';
	}
}