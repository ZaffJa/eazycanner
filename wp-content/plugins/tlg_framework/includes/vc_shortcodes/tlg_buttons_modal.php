<?php
/**
	DISPLAY SHORTCODE
**/
if( !function_exists('tlg_framework_modal_shortcode') ) {
	function tlg_framework_modal_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'icon' 			=> '',
			'btn_text' 		=> '',
			'btn_size' 		=> '',
			'btn_layout' 	=> 'btn btn-filled',
			'btn_hover'		=> '',
			'modal_layout' 	=> 'modal-1',
			'image' 		=> false,
			'customize_button' 	=> '',
			'btn_custom_layout' => 'btn',
			'btn_color' 		=> '',
			'btn_color_hover' 	=> '',
			'btn_bg' 			=> '',
			'btn_bg_hover' 		=> '',
			'btn_border' 		=> '',
			'btn_border_hover' 	=> '',
		), $atts ) );
		$custom_css 		= '';
		$element_id 		= uniqid('btn-');
		$element_id_modal 	= uniqid('modal-');

		// BUILD STYLE
		$styles_button 	= '';

		if ( $customize_button && 'yes' == $customize_button ) {
			$btn_layout 		= $btn_custom_layout;
			$btn_color 			= $btn_color 		? $btn_color : '#565656';
			$btn_bg 			= $btn_bg 			? $btn_bg : 'transparent';
			$btn_border 		= $btn_border 		? $btn_border : 'transparent';
			$btn_color_hover 	= $btn_color_hover 	? $btn_color_hover : $btn_color;
			$btn_bg_hover 		= $btn_bg_hover 	? $btn_bg_hover : $btn_bg;
			$btn_border_hover 	= $btn_border_hover ? $btn_border_hover : $btn_border;

			$styles_button 		.= 'color:'.$btn_color.';background-color:'.$btn_bg.';border-color:'.$btn_border.';';
			$custom_css 		.= '<style type="text/css" id="tlg-custom-css-'.$element_id.'">#'.$element_id.':hover{color:'.$btn_color_hover.'!important;background-color:'.$btn_bg_hover.'!important;border-color:'.$btn_border_hover.'!important;}</style>';
			echo "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		}

		// GET STYLE
		if ( ! empty( $styles_button ) ) {
			$style_button = 'style="' . esc_attr( $styles_button ) . '"';
		} else {
			$style_button = '';
		}
		
		// DISPLAY
		return '<a '.$style_button.' id="'.esc_attr($element_id).'" class="md-trigger '.esc_attr($btn_layout . ' ' .$btn_size . ' ' .$icon . ' ' .$btn_hover).'" data-modal="'.esc_attr($element_id_modal).'" href="#">'. 
					( 'play' == $btn_layout ? '<div class="play-button large inline"></div>' : ( 'play-dark' == $btn_layout ? '<div class="play-button dark large inline"></div>' : $btn_text) ) .
				'</a>'.
				'<div class="modal-button">'.
					'<div class="'.( $image ? 'image-bg' : '' ).' md-modal md-'.esc_attr($modal_layout).'" id="'.esc_attr($element_id_modal).'">'.
						'<div class="md-content">'.
							'<div class="md-content-inner">'.do_shortcode($content).'</div>'.
							( $image ? '<div class="background-content">'. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'</div>' : '' ).
						'</div>'.
						'<div class="text-center"><a class="md-close inline-block mt24" href="#"><i class="ti-close"></i></a></div>'.
					'</div><div class="md-overlay"></div>'.
				'</div>';
	}
	add_shortcode( 'tlg_modal', 'tlg_framework_modal_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_modal_shortcode_vc') ) {
	function tlg_framework_modal_shortcode_vc() {
		vc_map( array(
		    'name'                    => esc_html__( 'Modal Button' , 'tlg_framework' ),
		    'description'             => esc_html__( 'Create a modal button popup', 'tlg_framework' ),
		    'icon' 					  => 'tlg_vc_icon_modal',
		    'base'                    => 'tlg_modal',
		    'as_parent'               => array('except' => 'tlg_framework_tabs_content'),
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    'js_view' 				  => 'VcColumnView',
		    'category' 				  => wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
		    'params' 				  => array(
		    	array(
		    		'type' 			=> 'tlg_icons',
		    		'heading' 		=> esc_html__( 'Modal button icon (optional)', 'tlg_framework' ),
		    		'param_name' 	=> 'icon',
		    		'value' 		=> tlg_framework_get_icons(),
		    		'description' 	=> esc_html__( 'Leave blank to hide icons.', 'tlg_framework' )
		    	),
		    	array(
		    		'type' 			=> 'textfield',
		    		'heading' 		=> esc_html__( 'Modal button text', 'tlg_framework' ),
		    		'param_name' 	=> 'btn_text',
		    		'admin_label' 	=> true,
		    	),
		    	array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Modal button size', 'tlg_framework' ),
					'param_name' 	=> 'btn_size',
					'value' 		=> array(
						esc_html__( 'Normal', 'tlg_framework' ) 	=> '',
						esc_html__( 'Mini', 'tlg_framework' ) 	=> 'btn-xs',
						esc_html__( 'Small', 'tlg_framework' ) 	=> 'btn-sm',
						esc_html__( 'Large', 'tlg_framework' ) 	=> 'btn-lg',
						esc_html__( 'Block', 'tlg_framework' ) 	=> 'btn-block',
					)
			  	),
		    	array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Modal button style', 'tlg_framework' ),
					'param_name' 	=> 'btn_layout',
					'value' 		=> tlg_framework_get_button_layouts() + array( esc_html__( 'Light play button', 'tlg_framework' ) => 'play' )  + array( esc_html__( 'Dark play button', 'tlg_framework' ) => 'play-dark' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Modal button animation', 'tlg_framework' ),
					'param_name' 	=> 'btn_hover',
					'value' 		=> tlg_framework_get_hover_effects(),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Modal style', 'tlg_framework' ),
					'param_name' 	=> 'modal_layout',
					'value' 		=> array(
						esc_html__( 'Fade in & scale', 'tlg_framework' ) 	=> 'modal-1',
		    			esc_html__( 'Slide in right', 'tlg_framework' ) 	=> 'modal-2',
		    			esc_html__( 'Slide in bottom', 'tlg_framework' ) 	=> 'modal-3',
		    			esc_html__( 'Newspaper', 'tlg_framework' ) 		=> 'modal-4',
		    			esc_html__( 'Sticky up', 'tlg_framework' ) 		=> 'modal-5',
		    			esc_html__( 'Super scaled', 'tlg_framework' ) 	=> 'modal-6',
		    			esc_html__( 'Just me', 'tlg_framework' ) 			=> 'modal-7',
					),
					'admin_label' 	=> true,
				),
		    	array(
		    		'type' 			=> 'attach_image',
		    		'heading' 		=> esc_html__( 'Modal background image (optional)', 'tlg_framework' ),
		    		'param_name' 	=> 'image'
		    	),
		    	// Customize buttons - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
		            array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Enable customize button?', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select \'Yes\' if you want to customize colors/layout for this button.', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'customize_button',
						'value' 		=> array(
							esc_html__( 'No', 'tlg_framework' ) => '',
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
						),
						'group' 		=> esc_html__( 'Customize Button Options', 'tlg_framework' ),
				  	),
				  	array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Button customize layout', 'tlg_framework' ),
						'param_name' 	=> 'btn_custom_layout',
						'value' 		=> array(
							esc_html__( 'Standard', 'tlg_framework' ) => 'btn',
							esc_html__( 'Rounded', 'tlg_framework' ) 	=> 'btn btn-rounded',
						),
						'group' 		=> esc_html__( 'Customize Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
						'admin_label' 	=> true,
				  	),
		            array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button text color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button text.', 'tlg_framework' ),
						'param_name' 	=> 'btn_color',
						'group' 		=> esc_html__( 'Customize Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button background.', 'tlg_framework' ),
						'param_name' 	=> 'btn_bg',
						'group' 		=> esc_html__( 'Customize Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button border color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button border.', 'tlg_framework' ),
						'param_name' 	=> 'btn_border',
						'group' 		=> esc_html__( 'Customize Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER text color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button hover text.', 'tlg_framework' ),
						'param_name' 	=> 'btn_color_hover',
						'group' 		=> esc_html__( 'Customize Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button hover background.', 'tlg_framework' ),
						'param_name' 	=> 'btn_bg_hover',
						'group' 		=> esc_html__( 'Customize Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER border color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button hover border.', 'tlg_framework' ),
						'param_name' 	=> 'btn_border_hover',
						'group' 		=> esc_html__( 'Customize Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
		    )
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_modal_shortcode_vc' );
}

/**
	VC CONTAINER SHORTCODE CLASS
**/	
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_tlg_modal extends WPBakeryShortCodesContainer {}
}