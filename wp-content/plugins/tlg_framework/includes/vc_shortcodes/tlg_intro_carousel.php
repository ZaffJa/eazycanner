<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_intro_carousel_shortcode') ) {
	function tlg_framework_intro_carousel_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style' => 'intro-right'
		), $atts ) );
		$output = '<div class="intro-carousel '.esc_attr($style).'">'. do_shortcode($content) .'</div>';
		if( substr_count( $content, '[tlg_intro_carousel_content' ) > 1 ) {
			$output .= '<script type="text/javascript">jQuery(document).ready(function() {jQuery(\'.intro-carousel\').owlCarousel({nav: false, dots: true, center: true, loop:true, responsive:{0:{items:1}}});});</script>';
		}
		return $output;
	}
	add_shortcode( 'tlg_intro_carousel', 'tlg_framework_intro_carousel_shortcode' );
}

/**
	DISPLAY SHORTCODE CHILD
**/	
if( !function_exists('tlg_framework_text_image_shortcode') ) {
	function tlg_framework_intro_carousel_content_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'image' 		=> '',
			'title' 		=> '',
			'subtitle' 		=> '',
			'btn_link' 		=> '',
			'button_text' 	=> '',
			'button_layout'	=> '',
			'style' 		=> 'right',
			'hover' 		=> '',
			'customize_button' 	=> '',
			'btn_custom_layout' => 'btn',
			'btn_color' 		=> '',
			'btn_color_hover' 	=> '',
			'btn_bg' 			=> '',
			'btn_bg_hover' 		=> '',
			'btn_border' 		=> '',
			'btn_border_hover' 	=> '',
		), $atts ) );
		$custom_css 	= '';
		$link_prefix 	= '';
		$link_sufix 	= '';
		$element_id 	= uniqid('btn-');

		// BUILD STYLE
		$styles_button 	= '';

		if ( 'yes' == $customize_button ) {
			$button_layout 		= $btn_custom_layout;
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
		
		// LINK
		if( '' != $btn_link ) {
			$href = vc_build_link( $btn_link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				$link_prefix 	= '<a '.$style_button.' id="'.esc_attr($element_id).'" class="' .esc_attr($button_layout. ' ' .$hover). ' btn-lg btn-sm-sm text-center mr-0 mb0 mt24" href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}

		// DISPLAY
		return '<section class="image-square"><div class="col-md-6 image"><div class="background-content">'.
					wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .'</div></div>
				    <div class="col-md-6 content">'.
				    ( $title ? '<h5 class="widgettitle mb16">'. htmlspecialchars_decode($title) .'</h5>' : '' ) .
					( $subtitle ? '<div class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '' ) .
				    '<div>'.do_shortcode($content) .'</div>'.
				    ( $button_text ? $link_prefix. $button_text .$link_sufix : '' ).
				    '</div></section>';
	}
	add_shortcode( 'tlg_intro_carousel_content', 'tlg_framework_intro_carousel_content_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_intro_carousel_shortcode_vc') ) {
	function tlg_framework_intro_carousel_shortcode_vc() {
		vc_map( array(
		    'name' 						=> esc_html__( 'Intro Carousel' , 'tlg_framework' ),
		    'description' 				=> esc_html__( 'Create fancy text & image carousel', 'tlg_framework' ),
		    'icon' 						=> 'tlg_vc_icon_intro_carousel',
		    'base' 						=> 'tlg_intro_carousel',
		    'as_parent' 				=> array('only' => 'tlg_intro_carousel_content'),
		    'content_element' 			=> true,
		    'show_settings_on_create' 	=> false,
		    'js_view' 					=> 'VcColumnView',
		    'category' 					=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
		    'params' 					=> array(
		    	array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Display style', 'tlg_framework' ),
					'param_name' 	=> 'style',
					'value' 		=> array(
						esc_html__( 'Image right', 'tlg_framework' ) 	=> 'intro-right',
						esc_html__( 'Image left', 'tlg_framework' ) 	=> 'intro-left',
					),
					'description' 	=> esc_html__( 'Choose a display style for this intro box.', 'tlg_framework' )
				),
		    )
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_intro_carousel_shortcode_vc' );
}

/**
	REGISTER SHORTCODE CHILD
**/	
if( !function_exists('tlg_framework_intro_carousel_content_shortcode_vc') ) {
	function tlg_framework_intro_carousel_content_shortcode_vc() {
		$icons = tlg_framework_get_icons();
		vc_map( array(
		    'name'            => esc_html__( 'Intro Carousel Content', 'tlg_framework' ),
		    'description'     => esc_html__( 'Intro Carousel Content Element', 'tlg_framework' ),
		    'icon' 			  => 'tlg_vc_icon_intro_carousel',
		    'base'            => 'tlg_intro_carousel_content',
		    'category' 		  => wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
		    'content_element' => true,
		    'as_child'        => array('only' => 'tlg_intro_carousel'),
		    'params'          => array(
		    	array(
		    		'type' => 'attach_image',
		    		'heading' => esc_html__( 'Intro image', 'tlg_framework' ),
		    		'param_name' => 'image'
		    	),
		    	array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'tlg_framework' ),
					'param_name' 	=> 'title',
					'holder' 		=> 'div',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Subtitle', 'tlg_framework' ),
					'param_name' 	=> 'subtitle',
					'holder' 		=> 'div',
				),
		    	array(
					'type' 			=> 'textarea_html',
					'heading' 		=> esc_html__( 'Content', 'tlg_framework' ),
					'param_name' 	=> 'content',
					'holder' 		=> 'div'
				),
				array(
					'type' 			=> 'vc_link',
					'heading' 		=> esc_html__( 'Button link', 'tlg_framework' ),
					'param_name' 	=> 'btn_link',
					'value' 		=> '',
			  	),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Button text', 'tlg_framework' ),
					'param_name' => 'button_text',
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Button style', 'tlg_framework' ),
					'param_name' 	=> 'button_layout',
					'value' 		=> tlg_framework_get_button_layouts() + array( esc_html__( 'Link', 'tlg_framework' ) => 'btn-link' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Button animation', 'tlg_framework' ),
					'param_name' 	=> 'hover',
					'value' 		=> tlg_framework_get_hover_effects(),
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
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
				  	),
				  	array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Button customize layout', 'tlg_framework' ),
						'param_name' 	=> 'btn_custom_layout',
						'value' 		=> array(
							esc_html__( 'Standard', 'tlg_framework' ) => 'btn',
							esc_html__( 'Rounded', 'tlg_framework' ) 	=> 'btn btn-rounded',
						),
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
				  	),
		            array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button text color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button text.', 'tlg_framework' ),
						'param_name' 	=> 'btn_color',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button background.', 'tlg_framework' ),
						'param_name' 	=> 'btn_bg',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button border color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button border.', 'tlg_framework' ),
						'param_name' 	=> 'btn_border',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER text color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button hover text.', 'tlg_framework' ),
						'param_name' 	=> 'btn_color_hover',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button hover background.', 'tlg_framework' ),
						'param_name' 	=> 'btn_bg_hover',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER border color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button hover border.', 'tlg_framework' ),
						'param_name' 	=> 'btn_border_hover',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
		    ),
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_intro_carousel_content_shortcode_vc' );
}

/**
	VC CONTAINER SHORTCODE CLASS
**/
if(class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_tlg_intro_carousel extends WPBakeryShortCodesContainer {}
}
if(class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tlg_intro_carousel_content extends WPBakeryShortCode {}
}