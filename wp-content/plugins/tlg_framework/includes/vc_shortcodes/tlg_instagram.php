<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_instagram_shortcode') ) {
	function tlg_framework_instagram_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'username' 		=> '',
			'number' 		=> 8,
			'size' 			=> 'large',
			'target' 		=> '_blank',
			'style' 		=> 'col-6'
		), $atts ) );
		$output = '';

		if( $username ) {
			$media_array = tlg_framework_get_instagram( $username );
			if ( is_wp_error( $media_array ) ) {
				echo wp_kses_post( $media_array->get_error_message() );
			} else {
				$media_array = array_slice( $media_array, 0, $number );
				$output .= '<div class="instagram-feed '.esc_attr($style).'"><ul>';
				foreach ( $media_array as $item ) {
					$output .= '<li><a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"><img src="'. esc_url( $item[$size] ) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"/></a></li>';
				}
				$output .= '</ul></div>';
			}
		}
		return $output;
	}
	add_shortcode( 'tlg_instagram', 'tlg_framework_instagram_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_instagram_shortcode_vc') ) {
	function tlg_framework_instagram_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Instagram', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Instagram feed images', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_instagram',
			'base' 			=> 'tlg_instagram',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' .esc_html__( 'WordPress Theme', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Username', 'tlg_framework' ),
					'param_name' => 'username',
					'holder' => 'div',
				),
				array(
					'type' => 'tlg_number',
					'heading' => esc_html__( 'Number of images', 'tlg_framework' ),
					'param_name' => 'number',
					'holder' => 'div',
					'min' => 1,
					'max' => 12,
					'value' => '8',
					'description' => esc_html__( 'Please enter value must be less than or equal to 12. This because the widget scrapes image data from the Instagram website. Instagram recently made a change to their website which means we can only get 12 images now.', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Photo size', 'tlg_framework' ),
					'param_name' 	=> 'size',
					'value' 		=> array(
						esc_html__( 'Large', 'tlg_framework' ) 	=> 'large',
						esc_html__( 'Small', 'tlg_framework' ) 	=> 'small',
						esc_html__( 'Thumbnail', 'tlg_framework' ) => 'thumbnail',
						esc_html__( 'Original', 'tlg_framework' ) 	=> 'original',
					),
					'admin_label' 	=> false,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Open images in', 'tlg_framework' ),
					'param_name' 	=> 'target',
					'value' 		=> array(
						esc_html__( 'New window', 'tlg_framework' ) 	=> '_blank',
						esc_html__( 'Current window', 'tlg_framework' ) => '_self',
					),
					'admin_label' 	=> false,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Display style', 'tlg_framework' ),
					'param_name' 	=> 'style',
					'value' 		=> array(
						esc_html__( '6 Columns', 'tlg_framework' ) 	=> 'col-6', // 12.5%
						esc_html__( '4 Columns', 'tlg_framework' ) 	=> 'col-4', // 25%
						esc_html__( '2 Columns', 'tlg_framework' ) 	=> 'col-2', // 50%
					),
					'description' 	=> esc_html__( 'Choose a display style for this instagram.', 'tlg_framework' ),
					'admin_label' 	=> true,
				)
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_instagram_shortcode_vc' );
}