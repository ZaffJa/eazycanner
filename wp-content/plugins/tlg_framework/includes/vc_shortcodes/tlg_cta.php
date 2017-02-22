<?php
/**
	DISPLAY SHORTCODE
**/
if( !function_exists('tlg_framework_cta_shortcode') ) {
	function tlg_framework_cta_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' 		=> '',
			'subtitle' 		=> '',
			'btn_link' 		=> '',
			'button_text' 	=> '',
			'button_layout' => 'btn',
			'icon' 			=> '',
			'hover' 		=> '',
			// color
			'title_color' 		=> '',
			'subtitle_color' 	=> '',
			'icon_color' 		=> '',
			// customize button
			'customize_button' 	=> '',
			'btn_custom_layout' => 'btn',
			'btn_color' 		=> '',
			'btn_color_hover' 	=> '',
			'btn_bg' 			=> '',
			'btn_bg_hover' 		=> '',
			'btn_border' 		=> '',
			'btn_border_hover' 	=> '',
			// customize font
			'customize_font' 		=> '',
			'title_font' 			=> '',
			'subtitle_font' 		=> '',
			'title_size' 			=> '',
			'subtitle_size' 		=> '',
			'subtitle_padding' 		=> '',
			'subtitle_padding_top' 	=> '',
			'title_uppercase' 	 => 'yes',
			'subtitle_uppercase' => 'no',
		), $atts ) );
		$custom_css 	= '';
		$element_id 	= uniqid('cta-');
		$element_id_btn = uniqid('btn-');
		$fonts 			= array();

		// BUILD STYLE
		$styles_title 		= '';
		$styles_subtitle 	= '';
		$styles_icon 		= '';
		$styles_button 		= '';

		$styles_title 		.= $title_color 	? 'color:'.$title_color.'!important;' : '';
		$styles_subtitle 	.= $subtitle_color 	? 'color:'.$subtitle_color.'!important;' : '';
		$styles_icon 		.= $icon_color 		? 'color:'.$icon_color.'!important;' : '';

		if ( 'yes' == $customize_font ) {
			$custom_title_font = $custom_title_css = $custom_subtitle_font = $custom_subtitle_css = '';
			
			$styles_title 		.= '' != $title_size 			? 'font-size:'.$title_size.'px;line-height:'.($title_size+10).'px;' : '';
			$styles_title 		.= 'yes' == $title_uppercase 	? 'text-transform: uppercase!important;' : 'text-transform: none!important;';
			$styles_subtitle 	.= '' != $subtitle_size 		? 'font-size:'.$subtitle_size.'px;line-height:'.($subtitle_size+5).'px;' : '';
			$styles_subtitle 	.= '' != $subtitle_padding 		? 'padding-left:'.$subtitle_padding.'px;' : '';
			$styles_subtitle 	.= '' != $subtitle_padding_top 	? 'padding-top:'.$subtitle_padding_top.'px;' : '';
			$styles_subtitle 	.= 'yes' == $subtitle_uppercase ? 'text-transform: uppercase!important;' : 'text-transform: none!important;';
			
			// BUILD FONT
			$title_font 			 = $title_font ? tlg_framework_parsing_fonts( $title_font, 'Montserrat', 400 ) : '';
			if ( $title_font ) {
				$fonts[] 			 = $title_font['family'];
				$styles_title 		.= 'text-shadow:none;font-family:'.$title_font['name'].';font-weight:'.$title_font['weight'].';font-style:'.$title_font['style'].';';
			}
			$subtitle_font 			 = $subtitle_font ? tlg_framework_parsing_fonts( $subtitle_font, 'Droid Sans', 400 ) : '';
			if ( $subtitle_font ) {
				$fonts[] 			 = $subtitle_font['family'];
				$styles_subtitle 	.= 'text-shadow:none;font-family:'.$subtitle_font['name'].';font-weight:'.$subtitle_font['weight'].';font-style:'.$subtitle_font['style'].';';
			}
			if( count( $fonts ) ) {
				wp_enqueue_style( 'tlg-ggfonts-' . $element_id, tlg_framework_fonts_url( $fonts ), array() );
			}
		}

		if ( 'yes' == $customize_button ) {
			$button_layout 		= $btn_custom_layout;
			$btn_color 			= $btn_color 		? $btn_color : '#565656';
			$btn_bg 			= $btn_bg 			? $btn_bg : 'transparent';
			$btn_border 		= $btn_border 		? $btn_border : 'transparent';
			$btn_color_hover 	= $btn_color_hover 	? $btn_color_hover : $btn_color;
			$btn_bg_hover 		= $btn_bg_hover 	? $btn_bg_hover : $btn_bg;
			$btn_border_hover 	= $btn_border_hover ? $btn_border_hover : $btn_border;

			$styles_button 		.= 'color:'.$btn_color.';background-color:'.$btn_bg.';border-color:'.$btn_border.';';
			$custom_css 		.= '<style type="text/css" id="tlg-custom-css-'.$element_id_btn.'">#'.$element_id_btn.':hover{color:'.$btn_color_hover.'!important;background-color:'.$btn_bg_hover.'!important;border-color:'.$btn_border_hover.'!important;}</style>';
			echo "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		}

		// GET STYLE
		if ( ! empty( $styles_title ) ) {
			$style_title = 'style="' . esc_attr( $styles_title ) . '"';
		} else {
			$style_title = '';
		}
		if ( ! empty( $styles_subtitle ) ) {
			$style_subtitle = 'style="' . esc_attr( $styles_subtitle ) . '"';
		} else {
			$style_subtitle = '';
		}
		if ( ! empty( $styles_button ) ) {
			$style_button = 'style="' . esc_attr( $styles_button ) . '"';
		} else {
			$style_button = '';
		}
		if ( ! empty( $styles_icon ) ) {
			$style_icon = 'style="' . esc_attr( $styles_icon ) . '"';
		} else {
			$style_icon = '';
		}

		// LINK
		$link_prefix = $link_sufix = '';
		if( '' != $btn_link ) {
			$href = vc_build_link( $btn_link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				$link_prefix 	= '<a '.$style_button.' id="'.esc_attr($element_id_btn).'" class="' .esc_attr($button_layout . ' ' .$hover). ' btn-lg btn-sm-sm text-center mr-0 mb0 mt-xs-24" href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}

		// DISPLAY
		return '<div class="display-table">'.
					( $icon ? '<div class="display-cell display-none-sm"><i '.$style_icon.' class="fade-color ms-text mr-24 '. esc_attr($icon) .' icon"></i></div>' : '' ) .'
					<div class="display-cell text-center-sm">
						<div '.$style_title.' class="maintitle uppercase spacing-text">'. $title .'</div>
						<div '.$style_subtitle.' class="subtitle">'. $subtitle .'</div>
					</div>
					<div class="display-cell text-center-sm text-right">'.$link_prefix. $button_text.$link_sufix.'</div>
				</div>';
	}
	add_shortcode( 'tlg_cta', 'tlg_framework_cta_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_cta_shortcode_vc') ) {
	function tlg_framework_cta_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Call To Action', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Text & Button to grab attention', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_cta',
			'base' 			=> 'tlg_cta',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'tlg_framework' ),
					'param_name' => 'title',
					'holder' => 'div'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Subtitle', 'tlg_framework' ),
					'param_name' => 'subtitle',
					'holder' => 'div'
				),
				array(
					'type' => 'tlg_icons',
					'heading' => esc_html__( 'Click an Icon to choose', 'tlg_framework' ),
					'param_name' => 'icon',
					'value' => tlg_framework_get_icons(),
					'description' => esc_html__( 'Leave blank to hide icon.', 'tlg_framework' )
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
					'value' 		=> tlg_framework_get_button_layouts(),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Button animation', 'tlg_framework' ),
					'param_name' 	=> 'hover',
					'value' 		=> tlg_framework_get_hover_effects(),
					'admin_label' 	=> true,
				),
				// Color
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Title color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for title.', 'tlg_framework' ),
					'param_name' 	=> 'title_color',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Subtitle color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for subtitle.', 'tlg_framework' ),
					'param_name' 	=> 'subtitle_color',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'icon_color',
					'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
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
						'admin_label' 	=> true,
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

				// Font - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	            	array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Enable customize font?', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select \'Yes\' if you want to customize font style.', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'customize_font',
						'value' 		=> array(
							esc_html__( 'No', 'tlg_framework' ) => '',
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
						),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
				  	),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Title font style', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'title_font',
						'value' 		=> array_flip(tlg_framework_get_font_options()),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
					),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Title uppercase?', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'title_uppercase',
						'value' 		=> array(
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
							esc_html__( 'No', 'tlg_framework' ) => 'no',
						),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
				  	),
					array(
						'type' 			=> 'tlg_number',
						'heading' 		=> esc_html__( 'Title font size', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'title_size',
						'holder' 		=> 'div',
						'min' 			=> 1,
						'suffix' 		=> 'px',
						'admin_label' 	=> false,
						'description' 	=> esc_html__( 'Leave empty to use the default title font style.', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
					),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Subtitle font style', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'subtitle_font',
						'value' 		=> array_flip(tlg_framework_get_font_options()),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
					),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Subtitle uppercase?', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'subtitle_uppercase',
						'value' 		=> array(
							esc_html__( 'No', 'tlg_framework' ) => 'no',
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
						),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
				  	),
					array(
						'type' 			=> 'tlg_number',
						'heading' 		=> esc_html__( 'Subtitle font size', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'subtitle_size',
						'holder' 		=> 'div',
						'min' 			=> 1,
						'suffix' 		=> 'px',
						'admin_label' 	=> false,
						'description' 	=> esc_html__( 'Leave empty to use the default subtitle font style.', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
					),
					array(
						'type' 			=> 'tlg_number',
						'heading' 		=> esc_html__( 'Subtitle padding left', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'subtitle_padding',
						'holder' 		=> 'div',
						'min' 			=> 0,
						'suffix' 		=> 'px',
						'admin_label' 	=> false,
						'description' 	=> esc_html__( 'Leave empty to use the default subtitle padding.', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
					),
					array(
						'type' 			=> 'tlg_number',
						'heading' 		=> esc_html__( 'Subtitle padding top', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'subtitle_padding_top',
						'holder' 		=> 'div',
						'min' 			=> 0,
						'suffix' 		=> 'px',
						'admin_label' 	=> false,
						'description' 	=> esc_html__( 'Leave empty to use the default subtitle padding.', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
					),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_cta_shortcode_vc' );
}