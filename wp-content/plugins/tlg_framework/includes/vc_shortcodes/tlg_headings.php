<?php
/**
	DISPLAY SHORTCODE
**/		
if( !function_exists('tlg_framework_headings_shortcode') ) {
	function tlg_framework_headings_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' 		=> '',
			'subtitle' 		=> '',
			'alignment' 	=> 'center',
			'layout' 		=> 'top',
			'separator' 	=> '',
			'icon' 			=> '',
			'spacing' 		=> 'mb72',
			// color
			'title_color' 		=> '',
			'subtitle_color' 	=> '',
			'icon_color' 		=> '',
			// customize font
			'customize_font' 		=> '',
			'title_font' 			=> '',
			'subtitle_font' 		=> '',
			'title_size' 			=> '',
			'subtitle_size' 		=> '',
			'subtitle_padding' 		=> '',
			'subtitle_padding_top' 	=> '',
			'title_spacing' 	 	=> '',
			'subtitle_spacing' 	 	=> '',
			'title_uppercase' 	 => 'yes',
			'subtitle_uppercase' => 'no',
		), $atts ) );
		$output 	= '';
		$divider 	= '';
		$element_id = uniqid('heading-');
		$fonts 		= array();

		// BUILD STYLE
		$styles_title 		= '';
		$styles_subtitle 	= '';
		$styles_icon 		= '';

		$styles_title 		.= $title_color 	? 'color:'.$title_color.'!important;' : '';
		$styles_subtitle 	.= $subtitle_color 	? 'color:'.$subtitle_color.'!important;' : '';
		$styles_icon 		.= $icon_color 		? 'color:'.$icon_color.'!important;' : '';

		if ( 'yes' == $customize_font ) {
			$styles_title 		.= '' != $title_size 			? 'font-size:'.$title_size.'px;line-height:'.($title_size+10).'px;' : '';
			$styles_title 		.= '' != $title_spacing 		? 'letter-spacing:'.$title_spacing.'px!important;' : '';
			$styles_title 		.= 'yes' == $title_uppercase 	? 'text-transform: uppercase!important;' : 'text-transform: none!important;';
			$styles_subtitle 	.= '' != $subtitle_size 		? 'font-size:'.$subtitle_size.'px;line-height:'.($subtitle_size+5).'px;' : '';
			$styles_subtitle 	.= '' != $subtitle_spacing 		? 'letter-spacing:'.$subtitle_spacing.'px!important;' : '';
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
		if ( ! empty( $styles_icon ) ) {
			$style_icon = 'style="' . esc_attr( $styles_icon ) . '"';
		} else {
			$style_icon = '';
		}

		// DISPLAY
		if ( 'icon_title' == $separator ) {
			if( !$layout || 'top' == $layout || 'mid' == $layout ) {
				$output .= '<div class="display-table '.esc_attr($spacing).' mb-xs-40 text-'.esc_attr($alignment).'">';
				if ( 'right' == $alignment ) {
					$output .= '<div class="display-cell">';
					$output .= $title ? '<h5 '.$style_title.' class="widgettitle mb0">'. htmlspecialchars_decode($title) .'</h5>' : '';
					$output .= $subtitle ? '<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '';
					$output .= '</div>';
					$output .= '<div class="display-cell vertical-top" style="width:5%;">';
					$output .= $icon && 'none' != $icon ? '<i '.$style_icon.' class="'. esc_attr($icon) .' ml-15 ms-text"></i>' : '';
					$output .= '</div>';
				} else {
					$output .= '<div class="display-cell vertical-top" style="width:5%;">';
					$output .= $icon && 'none' != $icon ? '<i '.$style_icon.' class="'. esc_attr($icon) .' mr-15 ms-text"></i>' : '';
					$output .= '</div>';
					$output .= '<div class="display-cell">';
					$output .= $title ? '<h5 '.$style_title.' class="widgettitle mb0">'. htmlspecialchars_decode($title) .'</h5>' : '';
					$output .= $subtitle ? '<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '';
					$output .= '</div>';
				}
				$output .= '</div>';
			} else {
				$output .= '<div class="display-table '.esc_attr($spacing).' mb-xs-40 text-'.esc_attr($alignment).'">';
				if ( 'right' == $alignment ) {
					$output .= '<div class="display-cell">';
					$output .= $subtitle ? '<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '';
					$output .= $title ? '<h5 '.$style_title.' class="widgettitle mb0">'. htmlspecialchars_decode($title) .'</h5>' : '';
					$output .= '</div>';
					$output .= '<div class="display-cell" style="width:5%;">';
					$output .= $icon && 'none' != $icon ? '<i '.$style_icon.' class="'. esc_attr($icon) .' ml-15 ms-text"></i>' : '';
					$output .= '</div>';
				} else {
					$output .= '<div class="display-cell" style="width:5%;">';
					$output .= $icon && 'none' != $icon ? '<i '.$style_icon.' class="'. esc_attr($icon) .' mr-15 ms-text"></i>' : '';
					$output .= '</div>';
					$output .= '<div class="display-cell">';
					$output .= $subtitle ? '<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '';
					$output .= $title ? '<h5 '.$style_title.' class="widgettitle mb0">'. htmlspecialchars_decode($title) .'</h5>' : '';
					$output .= '</div>';
				}
				$output .= '</div>';
			}
		} else {
			if ( $separator ) {
				$divider .= '<div class="divider-wrap">';
				$divider .= ( 'icon' == $separator || 'line_icon' == $separator ) && $icon && 'none' != $icon ? '<i '.$style_icon.' class="'. esc_attr($icon) .'"></i>' : '';
				$divider .= ( 'line' == $separator || 'line_icon' == $separator ) ? '<div class="tlg-divider"></div>' : '';
				$divider .= ( 'icon' == $separator ) ? '<div class="tlg-divider" style="background-color: transparent"></div>' : '';
				$divider .= '</div>';
			}
			if( !$layout || 'top' == $layout ) {
				$output .= '<div class="'.esc_attr($spacing).' '.( $separator ? '' : 'mb16' ). ' mb-xs-40 text-'.esc_attr($alignment).'">';
				$output .= $title ? '<h5 '.$style_title.' class="widgettitle '.( $separator ? '' : 'mb0' ).'">'. htmlspecialchars_decode($title) .'</h5>' : '';	
				$output .= $divider;
				$output .= $subtitle ? '<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '';
				$output .= '</div>';
			} elseif( 'mid' == $layout ) {
				$output .= '<div class="'.esc_attr($spacing).' mb-xs-40 text-'.esc_attr($alignment).'">';
				$output .= $title ? '<h5 '.$style_title.' class="widgettitle mb0">'. htmlspecialchars_decode($title) .'</h5>' : '';
				$output .= $subtitle ? '<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '';
				$output .= $divider;
				$output .= '</div>';
			} elseif( 'bottom' == $layout ) {
				$output .= '<div class="'.esc_attr($spacing).' mb-xs-40 text-'.esc_attr($alignment).'">';
				$output .= $subtitle ? '<div '.$style_subtitle.' class="widgetsubtitle '.( $separator ? '' : 'mb8' ).'">'. htmlspecialchars_decode($subtitle) .'</div>' : '';
				$output .= $divider;
				$output .= $title ? '<h5 '.$style_title.' class="widgettitle mb0">'. htmlspecialchars_decode($title) .'</h5>' : '';	
				$output .= '</div>';
			}
		}
		return '<div class="headings-title">'.$output.'</div>';
	}
	add_shortcode( 'tlg_headings', 'tlg_framework_headings_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_headings_shortcode_vc') ) {
	function tlg_framework_headings_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Heading Title', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Awesome Heading Styles', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_heading',
			'base' 			=> 'tlg_headings',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
			'params' 		=> array(
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
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Alignment', 'tlg_framework' ),
					'param_name' 	=> 'alignment',
					'value' 		=> array(
						esc_html__( 'Center', 'tlg_framework' ) => 'center',
						esc_html__( 'Left', 'tlg_framework' ) => 'left',
						esc_html__( 'Right', 'tlg_framework' ) => 'right',
					)
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Heading configuration', 'tlg_framework' ),
					'param_name' 	=> 'layout',
					'value' 		=> array(
						esc_html__( 'Title, separator and subtitle', 'tlg_framework' ) => 'top',
						esc_html__( 'Subtitle, separator and title', 'tlg_framework' ) => 'bottom',
						esc_html__( 'Title, subtitle and separator', 'tlg_framework' ) => 'mid',
					)
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Separator', 'tlg_framework' ),
					'param_name' 	=> 'separator',
					'value' 		=> array(
						esc_html__( '(no separator)', 'tlg_framework' ) 	=> '',
						esc_html__( 'Line', 'tlg_framework' ) 			=> 'line',
						esc_html__( 'Icon', 'tlg_framework' ) 			=> 'icon',
						esc_html__( 'Icon title', 'tlg_framework' ) 		=> 'icon_title',
						esc_html__( 'Line with Icon', 'tlg_framework' ) 	=> 'line_icon',
					)
				),
				array(
					'type' 			=> 'tlg_icons',
					'heading' 		=> esc_html__( 'Click an Icon to choose', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Leave blank to hide icon.', 'tlg_framework' ),
					'param_name' 	=> 'icon',
					'value' 		=> tlg_framework_get_icons(),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Bottom spacing', 'tlg_framework' ),
					'param_name' 	=> 'spacing',
					'value' 		=> array(
						esc_html__( 'Standard', 'tlg_framework' ) => 'mb72',
						esc_html__( 'Medium', 'tlg_framework' ) => 'mb40',
						esc_html__( 'Small', 'tlg_framework' ) => 'mb16',
						esc_html__( 'Large', 'tlg_framework' ) => 'mb96',
						esc_html__( 'None', 'tlg_framework' ) => 'mb0',
					)
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

				// Font - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	            	array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Enable customize font?', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select \'Yes\' if you want to customize font style for this heading.', 'tlg_framework' ),
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
						'type' 			=> 'tlg_number',
						'heading' 		=> esc_html__( 'Title letter spacing', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'title_spacing',
						'holder' 		=> 'div',
						'suffix' 		=> 'px',
						'admin_label' 	=> false,
						'description' 	=> esc_html__( 'Leave empty to use the default title letter spacing.', 'tlg_framework' ),
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
						'heading' 		=> esc_html__( 'Subtitle letter spacing', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'subtitle_spacing',
						'holder' 		=> 'div',
						'suffix' 		=> 'px',
						'admin_label' 	=> false,
						'description' 	=> esc_html__( 'Leave empty to use the default subtitle letter spacing.', 'tlg_framework' ),
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
	add_action( 'vc_before_init', 'tlg_framework_headings_shortcode_vc' );
}