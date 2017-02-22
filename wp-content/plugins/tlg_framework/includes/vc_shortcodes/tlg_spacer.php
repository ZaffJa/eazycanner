<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_spacer_shortcode') ) {
	function tlg_framework_spacer_shortcode( $atts, $content = null ) {
		$height = $height_tablet = $height_mobile = '';
		extract(shortcode_atts(array(
			'height' => '10',
			'height_tablet' => '',
			'height_mobile' => '',
			'layout' => '',
		),$atts));
		if( $height_tablet == '' ) $height_tablet = $height;
		if( $height_mobile == '' ) $height_mobile = $height;
		$style  = 'clear:both;';
		$style .= 'display:block;';
		$style .= 'height:'.$height.'px;';
		$style .= $height < 0 ? 'margin-top:'.$height.'px;' : '';
		$style .= 'line' == $layout ? 'width:32px; margin-top: '.(int)(-$height/2).'px; margin-bottom: '.(int)($height/2).'px; border-bottom: 1px solid #d6d6d6;' : '';
		return '<div class="tlg-spacer" data-height="'.esc_attr($height).'" data-height-tablet="'.esc_attr($height_tablet).'" data-height-mobile="'.esc_attr($height_mobile).'" style="'.$style.'"></div>';
	}
	add_shortcode( 'tlg_spacer', 'tlg_framework_spacer_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_spacer_shortcode_vc') ) {
	function tlg_framework_spacer_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Spacer', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adjust space between components.', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_spacer',
			'base' 			=> 'tlg_spacer',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' => 'tlg_number',
					'heading' => esc_html__( 'Spacer Height - On Desktop', 'tlg_framework' ),
					'param_name' => 'height',
					'holder' => 'div',
					'suffix' => 'px',
					'description' => esc_html__('Enter value in pixels', 'tlg_framework'),
				),
				array(
					'type' => 'tlg_number',
					'heading' => esc_html__( 'Spacer Height - On Tablet', 'tlg_framework' ),
					'param_name' => 'height_tablet',
					'holder' => 'div',
					'suffix' => 'px',
					'description' => esc_html__('Enter value in pixels', 'tlg_framework'),
				),
				array(
					'type' => 'tlg_number',
					'heading' => esc_html__( 'Spacer Height - On Mobile', 'tlg_framework' ),
					'param_name' => 'height_mobile',
					'holder' => 'div',
					'suffix' => 'px',
					'description' => esc_html__('Enter value in pixels', 'tlg_framework'),
				),
				array(
		    		'type' 			=> 'dropdown',
		    		'heading' 		=> esc_html__( 'Display stype', 'tlg_framework' ),
		    		'param_name' 	=> 'layout',
		    		'value' 		=> array(
		    			esc_html__( 'Blank space', 'tlg_framework' ) 			=> '',
		    			esc_html__( 'Small solid line', 'tlg_framework' ) 	=> 'line',
		    		)
		    	),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_spacer_shortcode_vc' );
}