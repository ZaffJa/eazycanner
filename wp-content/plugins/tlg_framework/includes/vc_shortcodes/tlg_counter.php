<?php
/**
	DISPLAY SHORTCODE
**/		
if( !function_exists('tlg_framework_counter_shortcode') ) {
	function tlg_framework_counter_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'to' => '2009',
			'suffix_text' => '',
			'title' => '',
			'subtitle' => '',
			'icon' => '',
			'layout' => '',
			'color' => '',
			'icon_color' => '',
		), $atts ) );
		$output = '';
		$icon_color = $icon_color ? 'style="color:'.$icon_color.'!important;"' : '';
		switch ( $layout ) {
			case 'small-center':
				$output = '<div class="text-center '.esc_attr($color).'"><i '.$icon_color.' class="fade-color m-text '. esc_attr($icon) .' icon"></i>'. 
				'<div class="counter mt16 mb16">'.
					'<span class="counter-number">'. $to .'</span>'.
					( isset($suffix_text) && $suffix_text ? '<span class="counter-suffix">'.$suffix_text.'</span>' : '' ).
				'</div>'. 
				'<div class="maintitle uppercase">'. $title .'</div><div class="subtitle">'. $subtitle .'</div></div>';
				break;

			case 'large-center':
				$output = '<div class="text-center '.$color.'"><i '.$icon_color.' class="fade-color l-text '. esc_attr($icon) .' icon"></i>'. 
				'<div class="counter mt24 mb32 m-text">'. 
					'<span class="counter-number">'. $to .'</span>'.
					( isset($suffix_text) && $suffix_text ? '<span class="counter-suffix">'.$suffix_text.'</span>' : '' ).
				'</div>'. 
				'<div class="maintitle uppercase">'. $title .'</div><div class="subtitle">'. $subtitle .'</div></div>';
				break;

			default:
				$output = '<div class="text-left '.esc_attr($color).'"><i '.$icon_color.' class="fade-color m-text '. esc_attr($icon) .' icon"></i>'. 
				'<div class="counter">'. 
					'<span class="counter-number">'. $to .'</span>'.
					( isset($suffix_text) && $suffix_text ? '<span class="counter-suffix">'.$suffix_text.'</span>' : '' ).
				'</div>'. 
				'<div class="maintitle uppercase">'. $title .'</div><div class="subtitle">'. $subtitle .'</div></div>';
				break;
		}
		return $output;
	}
	add_shortcode( 'tlg_counter', 'tlg_framework_counter_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_counter_shortcode_vc') ) {
	function tlg_framework_counter_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Fact Counter', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds fact counter element', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_counter',
			'base' 			=> 'tlg_counter',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' => 'tlg_number',
					'heading' => esc_html__( 'To number', 'tlg_framework' ),
					'param_name' => 'to',
					'holder' => 'div',
					'min' => 1,
					'description' => esc_html__('Enter target number value', 'tlg_framework'),
					'value' => '2009'
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Suffix text', 'tlg_framework' ),
					'param_name' 	=> 'suffix_text',
					'value' 		=> '',
					'admin_label' 	=> true,
					'description' => esc_html__( 'Enter a text/character after counter number, Ex: %.', 'tlg_framework' )
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'tlg_framework' ),
					'param_name' 	=> 'title',
					'value' 		=> '',
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Subtitle', 'tlg_framework' ),
					'param_name' 	=> 'subtitle',
					'value' 		=> '',
					'admin_label' 	=> true,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Display style', 'tlg_framework' ),
					'param_name' => 'layout',
					'value' => array(
						esc_html__( 'Large left', 'tlg_framework' ) => '',
						esc_html__( 'Small center', 'tlg_framework' ) => 'small-center',
						esc_html__( 'Large center', 'tlg_framework' ) => 'large-center',
					),
					'admin_label' 	=> true,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Display color', 'tlg_framework' ),
					'param_name' => 'color',
					'value' => array(
						esc_html__( 'Default', 'tlg_framework' ) => '',
						esc_html__( 'Light', 'tlg_framework' ) => 'color-white',
					),
					'admin_label' 	=> true,
				),
				array(
					'type' => 'tlg_icons',
					'heading' => esc_html__( 'Click an Icon to choose', 'tlg_framework' ),
					'param_name' => 'icon',
					'value' => tlg_framework_get_icons(),
					'description' => esc_html__( 'Leave blank to hide icon.', 'tlg_framework' )
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'icon_color',
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_counter_shortcode_vc' );
}