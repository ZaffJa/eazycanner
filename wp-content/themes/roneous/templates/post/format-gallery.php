<?php
// Get gallery images in post content
$images = array();
$reg = preg_match('/\[gallery[^\]]*ids=\"(.*)\"[^\]]*\]/i', get_the_content(), $matches );
if( isset( $matches[1] ) ) { $attachments = explode( ',', $matches[1] );
    if( count($attachments) ) {
    	$output = '<div class="clearfix mb16">';
		foreach ( $attachments as $id ) {
			$img = '';
			$url = wp_get_attachment_image_src($id, 'full');
			if ( isset($url[0]) && $url[0] ) {
				$img = roneous_resize_image($url[0], 1280, 900, true);
				if ( $img ) $images[] = $img;
			}
		}
		if ( count($images) > 1 ) {
			// Display as gallery
			$output .= '<ul class="carousel-one-item carousel-olw-nav slides post-slider">';
			foreach ( $images as $image ) {
				$output .= '<li><img src="'. esc_url($image) .'" alt="'.esc_html__( 'gallery-item', 'roneous' ).'" /></li>';
			}
			$output .= '</ul>';
		} elseif ( count($images) == 1 ) {
			// Display as single image
			$output .= '<figure><img src="'. esc_url($images[0]) .'" alt="'.esc_html__( 'gallery-item', 'roneous' ).'" /></figure>';
		}
		$output .= '</div>';
		echo $output;
    }
}